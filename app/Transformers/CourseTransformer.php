<?php

namespace App\Transformers;

use App\Models\Course;
use League\Fractal\TransformerAbstract;

class CourseTransformer extends TransformerAbstract
{

    protected $list; //列表显示
    protected $permission; //权限控制
    protected $availableIncludes = ['chapters'];

    public function __construct($list = false, $permission = false)
    {
        $this->permission = $permission;
        $this->list = $list;
    }

    public function transform(Course $post)
    {
        if ($this->list) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'body' => make_excerpt($post->body),
                'banner' => $post->banner,
                'ori_price' => $post->ori_price,
                'now_price' => $post->now_price,
                'buy_count' => (int)$post->buy_count,
                'category_id' => $post->category_id,
                'teacher_id' => $post->teacher_id,
                'teacher' => $post->teacher()->select(['id', 'name', 'desc'])->first(),
                'created_at' => $post->created_at->toDateTimeString(),
            ];
        }
        if ($post->now_price === '0.00' || \Auth::guard('api')->user()->vip !== '铜牌会员') {
            $this->permission = true;
        }
        $bought = $this->permission;

        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => make_excerpt($post->body),
            'banner' => $post->banner,
            'ori_price' => $post->ori_price,
            'now_price' => $post->now_price,
            'buy_count' => (int)$post->buy_count,
            'zan_count' => (int)$post->zan_count,
            'is_zan' => $post->isUpVotedBy(\Auth::guard('api')->id()),
            'category_id' => $post->category_id,
            'category' => $post->category->name,
            'buynote' => $post->buynote->body,
            'teacher' => $post->teacher()->select(['id', 'name', 'desc', 'video_url', 'imgs'])->first(),
            'tags' => $post->getTags(),
            'is_bought' => $bought,//用户是否购买
            'created_at' => $post->created_at->toDateTimeString(),
        ];
    }

    public function includeChapters(Course $course)
    {
        return $this->collection($course->chapters()->orderBy('order', 'desc')->get(), new ChapterTransformer($this->permission));
    }
}