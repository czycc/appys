<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
{
    protected $list;
    protected $search;

    public function __construct($list = false, $search=false)
    {
        $this->list = $list;
        $this->search = $search;
    }

    public function transform(User $item)
    {
        if ($this->list) {
            //列表显示
            return [
                'id' => $item->id,
                'nickname' => $item->nickname,
                'avatar' => $item->avatar,
                'vip' => $item->vip,
//                'shop_status' => (int)$item->shop->status,
            ];
        }

        if ($this->search) {
            //根据id查询用户及店铺信息
            return [
                'id' => $item->id,
                'nickname' => $item->nickname,
                'phone' => substr_replace($item->phone, '****', 3, 4),
                'code' => $item->code,
                'avatar' => $item->avatar,
                'vip' => $item->vip,
                'follow_count' => $item->followings()->count(), //关注数
                'followed_count' => $item->followers()->count(), //被关注数
                'articles_count' => $item->articles()->count(), //文章数量
                'is_followed' => (boolean)$item->isFollowedBy(\Auth::guard('api')->id()),
                'expire_at' => (string)$item->expire_at,
                'created_at' => $item->created_at->toDateTimeString(),
                'shop' => (object)$item->shop()
                    ->withTags()
                    ->select([
                        'id', 'banner', 'introduction', 'shop_imgs', 'longitude', 'latitude', 'status', 'expire_at', 'province', 'city', 'district', 'address', 'wechat_qrcode', 'zan_count', 'created_at'
                    ])
                    ->first(),
            ];
        }

        if (\Auth::guard('api')->id() === $item->id) {
            //当本人时候
            return [
                'id' => $item->id,
                'nickname' => $item->nickname,
                'phone' => substr_replace($item->phone, '****', 3, 4),
                'code' => (string)$item->phone,
                'avatar' => $item->avatar,
                'bound_wechat' => ($item->wx_openid || $item->wx_unionid) ? true : false,
                'vip' => $item->vip,
                'notification_count' => (int)$item->notification_count,
                'bound_user' => $item->bound_id === 0 ? '未绑定' :
                    ($item->bound_status ? '已绑定' : '待通过'),
                'gold' => $item->gold,
                'silver' => $item->silver,
                'copper' => $item->copper,
                'expire_at' => (string)$item->expire_at,
                'created_at' => $item->created_at->toDateTimeString(),
                'shop' => (object)$item->getShop()->first(),
            ];
        }
        $data = [
            'id' => $item->id,
            'nickname' => $item->nickname,
            'phone' => substr_replace($item->phone, '****', 3, 4),
            'code' => $item->code,
            'avatar' => $item->avatar,
            'bound_wechat' => ($item->wx_openid || $item->wx_unionid) ? true : false,
            'vip' => $item->vip,
            'created_at' => $item->created_at->toDateTimeString(),
        ];


        return $data;
    }

}