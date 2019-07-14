<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Article;

class ArticleTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'tags'];

    public function transform(Article $item)
    {
        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'body' => $item->body,
            'top_img' => $item->top_img,
            'type' => $item->type,
            'media_url' => $item->media_url,
            'multi_imgs' => $item->multi_imgs,
            'price' => (int)$item->price,
            'zan_count' => (int)$item->zan_count,
            'status' => $item->status === 2 ? '待审核' : $item->status === 1 ? '已通过' : '未通过',
            'crated_at' => $item->created_at->toDateTimeString(),
            'updated_at' => $item->updated_at->toDateTimeString(),
        ];

        return $data;
    }

    public function includeUser(Article $item)
    {
        return $this->item($item->user, new UserTransformer());
    }

    public function includeTags(Article $item)
    {
        return $this->collection($item->tags, new TagTransformer());
    }
}