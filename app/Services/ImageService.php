<?php

namespace App\Services;

use Exception;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageService
{
    public function saveImage(UploadedFile $file)
    {
        //imageの生ファイル取得
        $image = Image::read($file);

        $image->scale(width: 1200);
        $encoded = $image->toJpeg(80);

        //imageをs3に保存 ファイルパスを返す
        $folder = 'photos';
        $fileName = $folder . '/' . Str::random(40) . '.jpg';

        $result = Storage::disk('s3')->put($fileName, $encoded->toString());
        if(!$result){throw new Exception('S3もしくはDBへの保存に失敗しました');}

        return $fileName;
    }
}
