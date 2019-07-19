<?php

namespace App\Models;

use Jcc\LaravelVote\CanBeVoted;

class Course extends Model
{
    use CanBeVoted;
    protected $vote = User::class;

    protected $fillable = ['title', 'banner', 'ori_price', 'now_price', 'body', 'show', 'recommend', 'order', 'buynote_id', 'teacher_id'];

    public function scopeRecommend($query)
    {
        //按推荐
        return $query->where('recommend', 1);
    }

    public function scopeBought($query)
    {
        //按购买数量
        return $query->orderBy('buy_count', 'desc');
    }
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function buynote()
    {
        return $this->belongsTo(Buynote::class);
    }

    public function teacher()
    {
       return $this->belongsTo(Teacher::class);
    }

    public function chapter()
    {
        return $this->hasMany(Chapter::class);
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
