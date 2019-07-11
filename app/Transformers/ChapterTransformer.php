<?php

namespace App\Transformers;

use App\Models\Chapter;
use League\Fractal\TransformerAbstract;

class ChapterTransformer extends TransformerAbstract
{
    protected $simple;

    public function __construct($simple = false)
    {
        $this->simple = $simple;
    }

    public function transform(Chapter $item)
    {
        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'price' => $item->price,
            'media_type' => $item->media_type,
            'permit' => true, //是否有权限
            'media_url' => $item->media_url
        ];
//        if ($this->simple) {
//            unset($data['media_url']);
//            unset($data['permit']);
//        }
        return $data;
    }
}