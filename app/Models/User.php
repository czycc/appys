<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Jcc\LaravelVote\Vote;
use Overtrue\LaravelFollow\Traits\CanVote;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, CanVote;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'password', 'code', 'wx_openid', 'wx_unionid', 'avatar', 'nickname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function getShop()
    {
        return $this->shop()->select([
            'id', 'shop_phone', 'real_name', 'banner', 'introduction', 'idcard', 'license', 'shop_imgs', 'longitude', 'latitude', 'status', 'expire_at', 'province', 'city', 'district', 'address', 'wechat_qrcode', 'zan_count', 'created_at'
        ]);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getVipAttribute($value)
    {
        return $value === 2 ? '代理会员' : $value === 1 ? '银牌会员' : '铜牌会员';

    }
}
