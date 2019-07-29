<?php

namespace App\Transformers;

use App\Models\News;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract
{

    public function transform(News $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'body' => $item->body,
            'thumbnail' => $item->thumbnail,
            'media_type' => $item->media_type,
            'media_url' => $item->media_url,
//            'category_id' => $item->category_id,
            'view_count' => (int)$item->view_count,
            'zan_count' => (int)$item->zan_count,
            'created_at' => $item->created_at->toDateTimeString(),
            'updated_at' => $item->updated_at->toDateTimeString(),
        ];
    }

}