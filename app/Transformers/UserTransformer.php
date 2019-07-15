<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['shop'];

    public function transform(User $item)
    {
        $data = [
            'id' => $item->id,
            'nickname' => $item->nickname,
            'phone' => substr_replace($item->phone, '****', 3, 4),
            'code' => $item->code,
            'avatar' => $item->avatar,
            'bound_wechat' => ($item->wx_openid || $item->wx_unionid) ? true : false,
            'vip' => $item->vip === 2 ? '代理' : $item === 1 ? '银牌' : '铜牌',
            'created_at' => $item->created_at->toDateTimeString()
        ];

        if (\Auth::guard('api')->id() === $item->id) {
            $data['notification_count'] = (int)$item->notifications_count;
            $data['bound_user'] = $item->bound_id === 0 ? '未绑定' :
                $item->bound_status ? '已绑定' : '待通过';
            $data['gold'] = $item->gold;
            $data['silver'] = $item->silver;
            $data['copper'] = $item->copper;
        }

        return $data;
    }

    public function includeShop(User $user)
    {
        return $this->item($user->shop, new ShopTransformer());
    }
}