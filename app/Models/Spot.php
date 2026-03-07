<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Spot extends Model
{
    protected $fillable = ['title','body','date','lat','lng','image','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // JSON変換時に署名付きs3URLをJSONに追加
    protected $appends = ['S3Url'];

    // s3参照URLを生成するアクセサ
    public function getS3UrlAttribute()
    {
        if (!$this->image) {
            return null;
        }else{
            return Storage::disk('s3')->temporaryUrl($this->image, now()->addMinutes(10));
        }

    }
}
