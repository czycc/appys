<?php

namespace App\Transformers;

use App\Models\CompanyPost;
use League\Fractal\TransformerAbstract;

class CompanyPostTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    protected $list;

    public function __construct($list = false)
    {
        $this->list = $list;
    }

    public function transform(CompanyPost $post)
    {
        if ($this->list) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'body' => make_excerpt($post->body),
                'thumbnail' => $post->thumbnail,
                'category_id' => (int)$post->category_id,
                'category' => $post->category->name,
                'created_at' => $post->created_at->toDateTimeString(),
            ];
        }
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'excerpt' => make_excerpt($post->body, 30),
            'thumbnail' => (string)$post->thumbnail,
            'media_type' => $post->media_type,
            'media_url' => (string)$post->media_url,
            'view_count' => (int)$post->view_count,
            'zan_count' => (int)$post->zan_count,
            'is_zan' => $post->isUpVotedBy(\Auth::guard('api')->id()),
            'category_id' => (int)$post->category_id,
            'category' => $post->category->name,
            'tags' => $post->getTags(),
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includeCategory(CompanyPost $post)
    {
        return $this->item($post->category, new CompanyCategoryTransformer());
    }
}