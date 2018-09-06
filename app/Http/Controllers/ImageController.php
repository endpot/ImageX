<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    /**
     * View image by code
     *
     * @param string $code
     * @return mixed
     */
    public function show($code)
    {
        $imagePath = public_path('images/404.jpg');

        $image = Image::where('code', $code)->first();
        if ($image) {
            $image->update([
                'views' => $image->views + 1
            ]);

            $fileName = $image->code . '.' . $image->ext;
            if ($this->fetchImageFromRemote($fileName)) {
                $imagePath = storage_path(
                    'app' .  DIRECTORY_SEPARATOR . $this->getLocalStoragePath($fileName)
                );
            }
        }

        return response()->file($imagePath);
    }


    /**
     * Delete image
     *
     * @param $deleteCode
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function destroy($deleteCode)
    {
        $image = Image::where('delete_code', $deleteCode)->first();
        if ($image) {
            $sameImageCount = Image::where('save_name', $image->save_name)->count();
            if ($sameImageCount > 1) {
                // just delete record
                $image->delete();
                return response('OK');
            } else {
                if (Storage::disk('local')->delete($this->getLocalStoragePath($image->save_name))
                    && Storage::disk('b2')->delete($this->getRemoteStoragePath($image->save_name))) {
                    // delete image and database record
                    $image->delete();
                    return response('OK');
                }
            }
        }

        return response('404');
    }

    public function create(Request $request)
    {
        $saveResult = [];
        if ($request->hasFile('images')) {
            $imageFiles = $request->file('images');

            $extraOptions = [
                'nsfw' => $request->input('nsfw') === 'true' ? true : false,
                'uploader_ip' => $request->ip(),
            ];
            foreach ($imageFiles as $imageFile) {
                if ($singleResult = $this->saveSingleImage($imageFile, $extraOptions)) {
                    $saveResult[] = $singleResult;
                }
            }
        }

        return response()->json([
            'success' => count($saveResult) > 0 ? true : false,
            'data' => $saveResult,
        ]);
    }

    private function validateImageFile($imageFile)
    {
        return $imageFile->getClientSize() < 5 * 1024 * 1024
            && in_array($imageFile->extension(), ['jpg', 'jpeg', 'bpm', 'gif', 'png']);
    }

    /**
     * Generate code
     *
     * @param int $length Code length
     * @param bool $check If check unique
     * @return string Result Code
     */
    private function generateCode($length = 5, $check = false)
    {
        do {
            $code = strtoupper(str_random($length));

            $duplicate = $check
                ? (Image::where('code', $code)->first() ? true : false)
                : false;
        } while ($check && $duplicate);

        return $code;
    }

    /**
     * Construct file's local relative path at storage's app directory
     *
     * @param string $fileName File Name
     * @return string Path
     */
    private function getLocalStoragePath($fileName = '')
    {
        $bashPath = 'public' . DIRECTORY_SEPARATOR . 'cache';
        return $fileName ? ($bashPath . DIRECTORY_SEPARATOR . $fileName) : $bashPath;
    }

    /**
     * Construct file's remote relative path in bucket
     *
     * @param string $fileName File Name
     * @return string Path
     */
    private function getRemoteStoragePath($fileName = '')
    {
        $bashPath = 'upload' . DIRECTORY_SEPARATOR . 'images';
        return $fileName ? ($bashPath . DIRECTORY_SEPARATOR . $fileName) : $bashPath;
    }

    /**
     * Try to fetch remote image from BackBlaze if file does not exist
     *
     * @param string $fileName Image file name with extension
     * @return bool Operation result
     */
    private function fetchImageFromRemote($fileName)
    {
        $localPath = $this->getLocalStoragePath($fileName);
        $isLocalFileExist = Storage::disk('local')->exists($localPath);

        if (!$isLocalFileExist) {
            $remotePath = $this->getRemoteStoragePath($fileName);
            if (Storage::disk('b2')->exists($remotePath)) {
                try {
                    $fileContent = Storage::disk('b2')->get($remotePath);
                    $isLocalFileExist = Storage::disk('local')->put($localPath, $fileContent);
                } catch (Exception $exception) {
                    $isLocalFileExist = false;
                }
            }
        }

        return $isLocalFileExist;
    }

    /**
     * Push image to remote
     *
     * @param string $fileName File name
     * @return bool Operation result
     */
    private function pushImageToRemote($fileName)
    {
        $localPath = $this->getLocalStoragePath($fileName);
        if (\Storage::disk('local')->exists($localPath)) {
            $remotePath = $this->getRemoteStoragePath($fileName);
            try {
                $localFileContent = \Storage::disk('local')->get($localPath);
                \Storage::disk('b2')->put($remotePath, $localFileContent);
            } catch (\Exception $exception) {
                return false;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Save single image file and push it to remote
     *
     * @param UploadedFile $imageFile
     * @param array $options Other Options
     * @return array
     */
    private function saveSingleImage($imageFile, $options = [])
    {
        if ($this->validateImageFile($imageFile)) {
            $code = $this->generateCode(5, true);
            $deleteCode = $code . $this->generateCode();
            $originalName = $imageFile->getClientOriginalName();
            $originalExtension = $imageFile->getClientOriginalExtension();

            $imageOperation = \ImageIntervention::make($imageFile);
            $imageWidth = $imageOperation->width();
            $imageHeight = $imageOperation->height();
            $imageSize = $imageOperation->fileSize();

            $fingerprint = md5_file($imageFile->path());

            $existImage = Image::where('fingerprint', $fingerprint)->first();
            $saveName = $existImage ? $existImage->save_name : $code . '.' . $originalExtension;

            if ($existImage || ($imageFile->storeAs($this->getLocalStoragePath(),
                        $saveName, ['disk' => 'local']) && $this->pushImageToRemote($saveName))) {
                $image = new Image();

                $image->code = $code;
                $image->delete_code = $deleteCode;
                $image->name = $originalName;
                $image->ext = $originalExtension;
                $image->width = $imageWidth;
                $image->height = $imageHeight;
                $image->nsfw = $options['nsfw'] ?: false;
                $image->uploader_ip = $options['uploader_ip'] ?: '';
                $image->fingerprint = $fingerprint;
                $image->save_name = $saveName;
                $image->size = $imageSize;
                $image->views = 0;
                $image->save();
            }
        }

        if (isset($image) && !empty($image->code)) {
            return [
                'name' => $image->name,
                'link' => route('showImage', [
                    'code' => $image->code,
                    'name' => $image->name,
                ]),
                'deleteLink' => route('deleteImage', ['deleteCode' => $image->delete_code])
            ];
        } else {
            return [];
        }
    }
}
