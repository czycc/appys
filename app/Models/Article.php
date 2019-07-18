<?php

namespace App\Models;

use Jcc\LaravelVote\CanBeVoted;

class Article extends Model
{
    use CanBeVoted;
    protected $vote = User::class;

    protected $fillable = ['title', 'top_img', 'body', 'type', 'media_url', 'multi_imgs', 'price'];

    protected $casts = [
        'multi_imgs' => 'array'
    ];
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * 返回标签列表
     */
    public function getTags()
    {
        return $this->tags()->select(['id', 'name'])->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * 用户简介
     */
    public function userBrief()
    {
        return $this->user()->select(['id', 'nickname', 'avatar'])->first();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getComments()
    {

    }
    public function shop()
    {
        return $this->hasManyThrough(User::class, Shop::class);
    }
}
