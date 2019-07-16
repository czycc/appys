<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['courses'];
    public function transform(Tag $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'post_count' => (int)$item->post_count
        ];
    }

    public function includeCourses(Tag $item)
    {

    }
}