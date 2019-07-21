<?php

namespace App\Models;

class Shop extends Model
{
    protected $fillable = ['shop_phone', 'real_name', 'banner', 'idcard', 'license', 'shop_imgs', 'longitude', 'latitude', 'province', 'city', 'district', 'address', 'wechat_qrcode'];

    protected $dates = [
        'created_at',
        'updated_at',
        'expire_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
