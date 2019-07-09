<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;

class MaterialPolicy extends Policy
{
    public function update(User $user, Material $material)
    {
        // return $material->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Material $material)
    {
        return true;
    }
}
