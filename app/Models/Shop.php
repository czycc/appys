<?php

namespace App\Models;

class Shop extends Model
{
    protected $fillable = ['shop_phone', 'introduction', 'real_name', 'banner', 'idcard', 'license', 'shop_imgs', 'longitude', 'latitude', 'province', 'city', 'district', 'address', 'wechat_qrcode'];

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

    /**
     * @param $value
     * @return mixed
     *
     * 转化json to array
     */
    public function getShopImgsAttribute($value)
    {
        return json_decode($value, true);
    }


    /**
     * @param $value
     * @return string
     * 转化 wechat_qrcode 字段为string
     */
    public function getWechatQrcodeAttribute($value)
    {
        return (string)$value;
    }
}
