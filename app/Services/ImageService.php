<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function saveImage(UploadedFile $imgFile)
    {
        //s3への保存とファイルパスを返す
        try{
            $imgManager = new ImageManager(new Driver());
            $image = $imgManager->read($imgFile);

            $encoded = $image->toJpeg(70);
            $fileName = 'photos/' . Str::random(40) . '.jpg';
            Storage::disk('s3')->put($fileName,(string) $encoded);

            return $fileName;

        }catch (Exception $e){
            \Log::error('画像保存エラー:'.$e->getMessage());
            return null;
        }

    }
}
