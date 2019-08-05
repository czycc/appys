<?php

namespace App\Transformers;

use App\Models\Flow;
use App\Models\FlowOut;
use League\Fractal\TransformerAbstract;

class FlowOutTransformer extends TransformerAbstract
{

    public function transform(FlowOut $item)
    {
        return [
            'id' => $item->id,
            'total_amount' => $item->total_amount,
            'status' => $item->status,
            'out_status' => $item->out_status,
            'created_at' => (string)$item->created_at,

        ];
    }

}