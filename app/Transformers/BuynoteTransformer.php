<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Buynote;

class BuynoteTransformer extends  TransformerAbstract {
    public function transform(Buynote $item)
    {
        return [
            'id' => $item->id,
            'body' => $item->body,
        ];
    }
}