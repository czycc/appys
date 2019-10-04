<?php

namespace App\Transformers;

use App\Models\Flow;
use App\Models\FlowOut;
use League\Fractal\TransformerAbstract;

class FlowOutTransformer extends TransformerAbstract
{

    public function transform(FlowOut $item)
    {
        $out_status = $item->out_status;

        if ($out_status != 1 && $item->is_offline == 1) {
            $out_status = true;
        }
        return [
            'id' => $item->id,
            'total_amount' => $item->total_amount,
            'status' => $item->status,
            'out_status' => $out_status,
            'created_at' => (string)$item->created_at,

        ];
    }

}