<?php
namespace App\Transformers;

use App\Models\Attention;
use League\Fractal\TransformerAbstract;

class AttentionTransformer extends  TransformerAbstract {

    protected $availableIncludes = ['user'];

    public function transform(Attention $item)
    {
        return [
            'id' => $item->id,
            'user_id' => $item->user_id,
            'to_user_id' => $item->to_user_id
        ];
    }

    public function includeUser(Attention $item)
    {
        return $this->item($item->user, new UserTransformer());
    }
}