<?php

namespace App\Models;

//use Jcc\LaravelVote\CanBeVoted;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Overtrue\LaravelFollow\Traits\CanBeVoted;

class Course extends Model
{
    use CanBeVoted, SoftDeletes;

    protected $vote = User::class;

    protected $fillable = ['title', 'banner', 'ori_price', 'now_price', 'body', 'show', 'recommend', 'order', 'buynote_id', 'teacher_id'];
    protected $dates = ['deleted_at'];

    public function scopeRecommend($query)
    {
        //按推荐
        return $query->where('recommend', 1);
    }

    /**
     * @param $query
     * @return mixed
     *
     * 列表显示部分字段
     */
    public function scopeList($query)
    {
        return $query->select([
            'id', 'title', 'body', 'banner', 'ori_price', 'now_price', 'buy_count', 'category_id', 'created_at', 'teacher_id',
        ]);
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
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function chapters()
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

    public function setBannerAttribute($banner)
    {
        //用于后台上传保存完整地址
        if (!filter_var($banner, FILTER_VALIDATE_URL)) {
            $this->attributes['banner'] = Storage::url($banner);
        } else {
            $this->attributes['banner'] = $banner;
        }

    }
}
