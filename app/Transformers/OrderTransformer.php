<?php

namespace App\Transformers;

use App\Models\Article;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{

    public function transform(Order $item)
    {
        $data = [
            'id' => $item->id,
//            'title' => $item->title,
            'total_amount' => $item->total_amount,
//            'type_id' => $item->type_id,
//            'type' => $item->type,
            'created_at' => (string)$item->created_at,
        ];
        if ($item->type == 'course') {
            $data['relation'] = Course::with(['teacher' => function ($query) {
                $query->withTrashed()->select(['id', 'name', 'desc']);
            }])->withTrashed()->select([
                'id', 'title', 'body', 'banner', 'teacher_id'
            ])
                ->find($item->type_id);
            $data['relation']->body = make_excerpt($data['relation']->body);
        } elseif (in_array($item->type, ['video', 'audio', 'topic'])) {
            $data['relation'] = Article::with(['user' => function ($query) {
                $query->withTrashed()->select(['id', 'nickname', 'avatar']);
            }])
                ->withTrashed()
                ->select(['id', 'title', 'top_img', 'user_id'])
                ->find($item->type_id);
        }

        return $data;
    }

}