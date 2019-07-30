<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTransformer extends TransformerAbstract
{
    public function transform(DatabaseNotification $item)
    {
        return [
            'notify_id' => $item->id,
            'msg' => $item->data,
            'read_at' => (string)$item->read_at,
            'created_at' => (string)$item->created_at
        ];
    }
}