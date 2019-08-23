<?php

namespace App\Observers;

use App\Models\Shop;
use App\Notifications\NormalNotify;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ShopObserver
{
    public function creating(Shop $shop)
    {
        //
    }

    public function updating(Shop $shop)
    {
        if (is_null($shop->expire_at)) {
            //店铺过期时间和用户一致
            $shop->expire_at = $shop->user->expire_at;
        }

        if ($shop->isDirty('recommend') && $shop->recommend) {
            $shop->user->msgNotify(new NormalNotify('店铺被设为推荐', '您的店铺已被设为推荐', 'shop', $shop->id));
        }

        if ($shop->isDirty('status')) {
            if ($shop->status === 0) {
                $shop->user->msgNotify(new NormalNotify('店铺未通过认证', '您的店铺未通过认证，请及时修改', 'shop', $shop->id));
            } elseif ($shop->status === 1) {
                $shop->user->msgNotify(new NormalNotify('店铺已通过认证', '恭喜，您的店铺已经通过认证。', 'shop', $shop->id));
            }
        }
    }
}