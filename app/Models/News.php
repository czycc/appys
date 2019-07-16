<?php

namespace App\Models;

use Jcc\LaravelVote\Vote;

class News extends Model
{
    use Vote;
    protected $vote = User::class;

    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'media_url', 'zan_count', 'weight'];

}
