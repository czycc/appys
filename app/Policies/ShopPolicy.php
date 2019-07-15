<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shop;

class ShopPolicy extends Policy
{
    public function update(User $user, Shop $shop)
    {
         return $shop->user_id == $user->id;
    }

    public function destroy(User $user, Shop $shop)
    {
        return true;
    }
}
