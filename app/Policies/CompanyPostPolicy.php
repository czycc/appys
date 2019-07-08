<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CompanyPost;

class CompanyPostPolicy extends Policy
{
    public function update(User $user, CompanyPost $company_post)
    {
        // return $company_post->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, CompanyPost $company_post)
    {
        return true;
    }
}
