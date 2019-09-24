<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Shop;

class ShopTransformer extends TransformerAbstract
{
    protected $list;

    public function __construct($list = false)
    {
        $this->list = $list;
    }

    public function transform(Shop $item)
    {
        if ($this->list) {
            //店铺列表
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'updated_at' => $item->updated_at->toDateTimeString(),
                'official' => $item->status === 1,
                'user' => $item->user()->select(['id', 'nickname', 'avatar'])->first(),
            ];
        }

        $data = [
            'id' => $item->id,
            'shop_phone' => $item->shop_phone,
            'real_name' => $item->real_name,
            'banner' => $item->banner,
            'introduction' => $item->introduction,
            'zan_count' => (int)$item->zan_count,
            'shop_imgs' => $item->shop_imgs,
            'longitude' => $item->longitude,
            'latitude' => $item->latitude,
            'province' => $item->province,
            'city' => $item->city,
            'district' => (string)$item->district,
            'address' => (string)$item->address,
            'wechat_qrcode' => (string)$item->wechat_qrcode,
            'created_at' => $item->created_at->toDateTimeString(),
        ];

        if (\Auth::guard('api')->id() === $item->user_id) {
            //店铺本人
            $data['idcard'] = $item->idcard;
            $data['license'] = $item->license;
            $data['status'] = $item->status;
            $data['user_id'] = (int)$item->user_id;
            $data['tags'] = $item->tags()->select(['id', 'name'])->get();
            return $data;
        }
//        if ($item->status !== 1) {
//            //未审核
//            return [];
//        }
        return $data;
    }
}