<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    public function transform(Tag $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'post_count' => (int)$item->post_count
        ];
    }
}