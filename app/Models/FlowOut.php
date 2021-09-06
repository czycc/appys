<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Pay;
use App\Notifications\NormalNotify;

class FlowOut extends Model
{
    protected $fillable = ['total_amount', 'out_method', 'ali_account'];

    public $casts = [
        'status' => 'boolean',
        'out_status' => 'boolean',
        'is_offline' => 'boolean',
        'out_info' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            //扣除用户提现金额
            \Auth::guard('api')->user()->balance -= $model->total_amount;
            \Auth::guard('api')->user()->save();
        });

        static::updating(function ($model) {

            //用户提现
            if ($model->status == 1 && $model->out_status != 1) {
                if ($model->out_method === 'wechat') {
                    Pay::wechat()->transfer($model->out_info);
                    $model->out_status = 1;
                    $user = User::find($model->user_id);
                    $user->msgNotify(new NormalNotify(
                        '提现成功',
                        '您已成功提现' . $model->total_amount,
                        'flow_out'
                    ));
                } elseif ('$model->out_method === alipay') {
                    Pay::alipay()->transfer($model->out_info);
                    $model->out_status = 1;
                    $user = User::find($model->user_id);
                    $user->msgNotify(new NormalNotify(
                        '提现成功',
                        '您已成功提现' . $model->total_amount,
                        'flow_out'
                    ));
                }

            }
            if ($model->is_offline) {
                $model->status = 1;
            }

        });
    }
}
