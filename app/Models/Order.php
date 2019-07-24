<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['no', 'title', 'total_amount', 'paid_at', 'pay_method', 'pay_no', 'type', 'type_id', 'closed'];

    protected $casts = [
        'closed' => 'boolean'
    ];
    protected $dates = [
        'paid_at',
    ];

    const TYPE_ARTICLE = 'article';
    const TYPE_COURSE = 'course';
    const TYPE_VIP = 'vip';
    const TYPE_CHAPTER = 'chapter';

    public static function boot()
    {
        parent::boot();

        //监听模型事件，在写入前触发
        static::creating(function ($model) {
            //如果没有订单流水号
            if (!$model->no) {
                $model->no = static::findAvailableNo();
                if (!$model->no) {
                    return false;
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function findAvailableNo()
    {
        //订单流水号前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            $no = $prefix . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            //判断是否存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('生成订单号失败');
        return false;
    }
}
