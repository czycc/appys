<?php

namespace App\Transformers;

use App\Models\Flow;
use App\Models\GuestBook;
use League\Fractal\TransformerAbstract;

class GuestBookTransformer extends TransformerAbstract
{

    public function transform(GuestBook $item)
    {
        $data = [
            'id' => $item->id,
            'body' => $item->body,
            'user_id' => $item->user_id,
            'guest_id' => $item->guest_id,
//            'guest_book_id' => $item->guest_book_id,
            'created_at' => (string)$item->created_at,
            'guest' => $item->guest()->select(['id', 'nickname', 'avatar'])->first()
        ];

        if ($item->guest_book_id === 0) {
            $data['replies'] = GuestBook::with(['guest' => function ($query) {
                $query->select(['id', 'nickname', 'avatar']);
            }])->select(['id', 'user_id', 'guest_id', 'guest_book_id', 'body', 'created_at'])
                ->where('guest_book_id', $item->id)
                ->where('user_id', $item->user_id)
                ->orderByDesc('id')
                ->get();
        }
        return $data;
    }

}