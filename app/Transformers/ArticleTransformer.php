<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Article;

class ArticleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    protected $permission;

    public function __construct($permission = false)
    {
        $this->permission = $permission;

    }

    public function transform(Article $item)
    {
        //当前用户为自己时拥有权限查看
        if (\Auth::guard('api')->id() === $item->id) {
            $this->permission = true;
        }
        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'top_img' => $item->top_img,
            'type' => $item->type,
            'price' => (int)$item->price,
            'zan_count' => (int)$item->zan_count,
            'status' => $item->status === 2 ? '待审核' : $item->status === 1 ? '已通过' : '未通过',
            'crated_at' => $item->created_at->toDateTimeString(),
//            'updated_at' => $item->updated_at->toDateTimeString(),
            'permission' => $this->permission,
            'details' => [
                'body' => $this->permission ? $item->body : '',
                'media_url' => $this->permission ? $item->media_url : '',
                'multi_imgs' => $this->permission ? $item->multi_imgs : '',
            ], //有权限才可以查看
            'user' => $item->userBrief(),
            'tags' => $item->getTags()
        ];

        return $data;
    }

    public function includeUser(Article $item)
    {
        return $this->item($item->user, new UserTransformer());
    }

    public function includeTags(Article $item)
    {
        return $this->collection($item->tags, new TagTransformer());
    }
}