<?php

namespace App\Observers;

use App\Models\Shop;

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
    }
}