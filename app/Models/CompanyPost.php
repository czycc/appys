<?php

namespace App\Models;

use Overtrue\LaravelFollow\Traits\CanBeVoted;

class CompanyPost extends Model
{
    use CanBeVoted;

    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'media_url', 'category_id', 'view_count', 'zan_count', 'weight'];

    public function category()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id');
    }

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
}
