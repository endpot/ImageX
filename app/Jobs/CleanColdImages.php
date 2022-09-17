<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use App\Models\Image;

class CleanColdImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lastWeeks = Carbon::parse('-5 days')->toDateTimeString();
        $hotImages = Image::where('updated_at', '>', $lastWeeks)->get();

        $cacheDirectory = 'public' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;

        $cacheImages = \Storage::disk('local')->files($cacheDirectory);

        $safeList = $hotImages->map(function ($hotImage) use ($cacheDirectory) {
            return $cacheDirectory . $hotImage->code . '.' . $hotImage->ext;
        })->toArray();


        $deleteList = array_filter($cacheImages, function ($cacheImage) use ($safeList) {
            return !in_array($cacheImage, $safeList);
        });

        \Storage::disk('local')->delete($deleteList);
    }
}
