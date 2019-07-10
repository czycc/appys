<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy extends Policy
{
    public function update(User $user, Course $course)
    {
        // return $course->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Course $course)
    {
        return true;
    }
}
