<?php

namespace App\Transformers;

use App\Models\Course;
use League\Fractal\TransformerAbstract;

class FreeCourseTransformer extends TransformerAbstract
{
    protected $permission; //权限控制
    protected $availableIncludes = ['chapters'];

    public function __construct($permission = false)
    {
        $this->permission = $permission;
    }

    public function transform(Course $post)
    {
        if ($post->now_price === '0.00') {
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
            'is_zan' => false,
            'category_id' => $post->category_id,
            'category' => $post->category->name,
            'buynote' => $post->buynote->body,
            'teacher' => $post->teacher()->select(['id', 'name', 'desc', 'video_url', 'imgs'])->first(),
            'tags' => $post->getTags(),
            'is_bought' => $bought,//用户是否购买
            'created_at' => $post->created_at->toDateTimeString(),
        ];
    }
}