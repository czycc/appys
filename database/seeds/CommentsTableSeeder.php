<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Comment::class, 100)->create();
        Comment::all()->each(function (Comment $comment) {
            factory(Comment::class, 1)->create([
                'comment_id' => $comment->id,
                'article_id' => $comment->article_id,
                'user_id' => $comment->user_id
            ]);
        });
    }

}

