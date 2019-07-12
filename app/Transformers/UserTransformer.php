<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends  TransformerAbstract {
    public function transform(User $item)
    {
        return [
            'id' => $item->id,
            'nickname' => $item->nickname,
            'phone' => substr_replace($item->phone, '*', 4, 7),
            'code' => $item->code,
            'avatar' => $item->avatar,
            'bound_wechat' => ($item->wx_openid || $item->wx_unionid) ? true : false,
            'created_at' => $item->created_at->toDateTimeString()
        ];
    }
}