<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Shop;

class ShopTransformer extends TransformerAbstract
{
    public function transform(Shop $item)
    {

        $data = [
            'id' => $item->id,
            'shop_phone' => $item->shop_phone,
            'real_name' => $item->real_name,
            'banner' => $item->banner,
            'shop_imgs' => $item->shop_imgs,
            'longitude' => $item->longitude,
            'latitude' => $item->latitude,
            'province' => $item->province,
            'city' => $item->city,
            'district' => $item->district,
            'address' => $item->address,
            'wechat_qrcode' => $item->wechat_qrcode,
            'crated_at' => $item->created_at->toDateTimeString(),
            'updated_at' => $item->updated_at->toDateTimeString(),
        ];

        if (\Auth::guard('api')->id() === $item->user_id) {
            //店铺本人
            $data['idcard'] = $item->idcard;
            $data['license'] = $item->license;
            $data['status'] = $item->status === 2 ? '认证中' : ($item->status === 1 ? '认证通过' : '认证失败');
            $data['user_id'] = (int)$item->user_id;
            return $data;
        }
        if ($item->status !== 1) {
            //未审核
            return [];
        }
        return $data;
    }
}