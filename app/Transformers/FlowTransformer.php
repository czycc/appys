<?php

namespace App\Transformers;

use App\Models\Flow;
use League\Fractal\TransformerAbstract;

class FlowTransformer extends TransformerAbstract
{

    public function transform(Flow $item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'total_amount' => $item->total_amount,
            'created_at' => $item->created_at->toDateTimeString(),
        ];
    }

}