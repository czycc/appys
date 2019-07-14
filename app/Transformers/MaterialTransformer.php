<?php

namespace App\Transformers;

use App\Models\MaterialCategory;
use App\Models\Material;
use League\Fractal\TransformerAbstract;

class MaterialTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['category'];

    public function transform(Material $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'thumbnail' => $post->thumbnail,
            'media_type' => $post->media_type,
            'media_url' => $post->media_url,
            'category_id' => $post->category_id,
            'view_count' => (int)$post->view_count,
            //            'zan_count' => $post->zan_count,
            'crated_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includeCategory(Material $post)
    {
        return $this->item($post->category, new MaterialCategoryTransformer());
    }
}