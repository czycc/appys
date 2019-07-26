<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Reply;

class RepliesTransformer extends TransformerAbstract
{
    public function transform(Reply $item)
    {
        return [
            'content' => $item->content,
            'nickname' => $item->user->nickname,
            'avatar' => $item->user->avatar
        ];
    }
}