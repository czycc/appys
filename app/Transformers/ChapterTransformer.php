<?php

namespace App\Transformers;

use App\Models\Chapter;
use League\Fractal\TransformerAbstract;

class ChapterTransformer extends TransformerAbstract
{
    protected $permission;

    public function __construct($permission = false)
    {
        $this->permission = $permission;
    }

    public function transform(Chapter $item)
    {
        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'price' => $item->price,
            'media_type' => $item->media_type,
            'permission' => $this->permission, //是否有权限
            'media_url' => $this->permission ? $item->media_url : '',
            'created_at' => $item->created_at->toDateTimeString()
        ];
        return $data;
    }
}