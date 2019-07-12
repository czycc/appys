<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Media;

class MediaTransformer extends  TransformerAbstract {
    public function transform(Media $item)
    {
        return [
            'id' => $item->id,
            'user_id' => $item->user_id,
            'type' => $item->type,
            'media_type' => $item->media_type,
            'media_url' => $item->media_url,
            'created_at' => $item->created_at->toDateTimeString()
        ];
    }
}