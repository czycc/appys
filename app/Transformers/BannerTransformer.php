<?php

namespace App\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{

    public function transform(Banner $item)
    {
        return [
            'id' => $item->id,
            'img_url' => $item->img_url,
            'desc' => $item->desc,
            'type' => $item->type,
            'type_id' => $item->type_id
        ];
    }

}