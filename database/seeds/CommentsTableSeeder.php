<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $users = \App\Models\User::all()->pluck('id')->toArray();
        factory(Comment::class, 400)->create();
        Comment::all()->each(function (Comment $comment) use ($users) {
            factory(\App\Models\Reply::class, random_int(1, 3))->create([
                'comment_id' => $comment->id,
                'user_id' => array_random($users)
            ]);
        });
    }

}

