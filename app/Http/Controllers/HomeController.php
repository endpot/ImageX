<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'current' => 'home',
            'summary' => [
                'total_count' => $this->getImageCount(),
                'total_views' => $this->getImageViews(),
                'new_image_count' => $this->getNewImageCount(),
                'uploader_count' => $this->getUploaderCount(),
            ],
            'images' => $this->getRandomImageCollection(),
        ]);
    }

    private function getImageCount()
    {
        return Image::count();
    }

    private function getImageViews()
    {
        return Image::sum('views');
    }

    private function getNewImageCount()
    {
        return Image::where('created_at', '>', Carbon::today())->count();
    }

    private function getUploaderCount()
    {
        return DB::table('images')->count(DB::raw('DISTINCT uploader_ip'));
    }

    private function getRandomImageCollection($count = 20)
    {
        $minId = Image::where('nsfw', 0)->min('id');
        $maxId = Image::where('nsfw', 0)->max('id');
        $beginId = mt_rand($minId, $maxId);

        return Image::where('id', '>', $beginId)
            ->where('nsfw', 0)
            ->where('updated_at', '>', today())
            ->limit($count)->get();
    }
}
