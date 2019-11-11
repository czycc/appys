<?php

namespace App\Models;

use App\Notifications\NormalNotify;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanVote;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, CanVote, CanBeFollowed, CanFollow, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'password','bound_id', 'bound_status', 'code', 'wx_openid', 'wap_openid', 'wx_unionid', 'avatar', 'nickname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'expire_at',
        'deleted_at'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * 个人持有虚拟币
     */
    public function userCoin()
    {
        return $this->hasOne(UserCoin::class);
    }

    public function coin()
    {
        if ($userCoin = $this->userCoin()->first()) {
            return $userCoin->coin;
        }
        return 0;
    }
    public function getShop()
    {
        return $this->shop()
            ->with(['tags' => function ($query) {
                $query->select(['id', 'name']);
            }])
            ->select([
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
        //会员状态
        if ($this->expire_at < Carbon::now()) {
            return '铜牌会员';
        }
        return $value === 2 ? '代理会员' : ($value === 1 ? '银牌会员' : '铜牌会员');

    }

    /**
     * @param $instance
     *
     * 绑定上级通知
     */
    public function msgNotify($instance)
    {
        //同一个人不返回
        if ($this->id == \Auth::id()) {
            return;
        }
        $this->increment('notification_count');

        $this->notify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function extra()
    {
        return $this->hasOne(UserExtra::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function (User $model) {

            if ($model->isDirty('expire_at')) {
                //同步更新店铺过期时间
                Shop::where('user_id', $model->id)
                    ->update(['expire_at' => $model->expire_at]);
                if ($model->vip === '代理会员') {
                    //通知成为代理
                    $model->msgNotify(new NormalNotify(
                        '代理会员通知',
                        '代理会员到期时间：'. $model->expire_at,
                        'vip'
                    ));

                    //上级获币，银牌得银币，代理得金币
                    if ($model->bound_status) {
                        $top = User::find($model->id);

                        $configure = Configure::first();
                        if ($top->vip === '银牌会员') {
                            $top->increment('silver', $configure->buy_vip3_top_vip2);
                        } elseif ($top->vip === '代理会员') {
                            $top->increment('gold', $configure->buy_vip3_top_vip3);
                        }
                    }
                }
            }

        });
    }
}
