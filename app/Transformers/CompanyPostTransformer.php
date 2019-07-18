<?php

namespace App\Transformers;

use App\Models\CompanyPost;
use League\Fractal\TransformerAbstract;

class CompanyPostTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function transform(CompanyPost $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'thumbnail' => $post->thumbnail,
            'media_type' => $post->media_type,
            'media_url' => $post->media_url,
            'view_count' => (int)$post->view_count,
            'zan_count' => (int)$post->zan_count,
            'category_id' => (int)$post->category_id,
            'category' => $post->category->name,
            'tags' => $post->getTags(),
            'crated_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includeCategory(CompanyPost $post)
    {
        return $this->item($post->category, new CompanyCategoryTransformer());
    }
}