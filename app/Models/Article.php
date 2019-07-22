<?php

namespace App\Models;

//use Jcc\LaravelVote\CanBeVoted;

use Overtrue\LaravelFollow\Traits\CanBeVoted;

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

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * 获取关联评论，及评论的昵称头像
     */
    public function getComments()
    {
        return $this->comments()
            ->with(['user' => function ($query) {
                $query->select(['id', 'nickname', 'avatar']);
            }])
            ->orderBy('id', 'desc')
            ->limit(300)
            ->get();
    }
    public function shop()
    {
        return $this->hasManyThrough(User::class, Shop::class);
    }

    /**
     * @param $value
     * @return mixed
     * 转化json数组
     */
    public function getMultiImgsAttribute($value)
    {
        return json_decode($value, true);
    }
}
