<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;

class TeacherPolicy extends Policy
{
    public function update(User $user, Teacher $teacher)
    {
        // return $teacher->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Teacher $teacher)
    {
        return true;
    }
}
