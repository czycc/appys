<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Flow extends Model
{
    protected $guarded =['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        //创建之后
        static::created(function ($model) {

            //同步更新用户收益余额
            DB::table('users')->increment('balance', $model->total_amount, [
                'id' => $model->user_id
            ]);

        });
    }
}
