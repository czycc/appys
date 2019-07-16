<?php

namespace App\Models;

use Jcc\LaravelVote\CanBeVoted;

class Article extends Model
{
    use CanBeVoted;
    protected $vote = User::class;

    protected $fillable = ['title', 'top_img', 'body', 'type', 'media_url', 'multi_imgs', 'price'];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function shop()
    {
        return $this->hasManyThrough(User::class, Shop::class);
    }
}
