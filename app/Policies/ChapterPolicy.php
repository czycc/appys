<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chapter;

class ChapterPolicy extends Policy
{
    public function update(User $user, Chapter $chapter)
    {
        // return $chapter->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Chapter $chapter)
    {
        return true;
    }
}
