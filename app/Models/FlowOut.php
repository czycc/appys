<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowOut extends Model
{
    protected $fillable =['total_amount', 'out_method', 'ali_account'];

    public $casts =[
        'status' => 'boolean',
        'out_status' => 'boolean',
        'is_offline' => 'boolean',
        'out_info' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot() {

        parent::boot();

        static::creating(function ($model) {

            //扣除用户提现金额
            \Auth::guard('api')->user()->balance -= $model->total_amount;
            \Auth::guard('api')->user()->save();
        });
    }
}
