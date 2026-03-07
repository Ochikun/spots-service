<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'introduction'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function spots()
    {
        return $this->hasMany(Spot::class);
    }

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
