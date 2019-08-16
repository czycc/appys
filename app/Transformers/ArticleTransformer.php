<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Article;

class ArticleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    protected $permission;
    protected $list;

    public function __construct($list = false, $permission = false)
    {
        $this->permission = $permission;
        $this->list = $list;
    }

    public function transform(Article $item)
    {
        if ($this->list) {
            //列表形式
            return [
                'id' => $item->id,
                'title' => $item->title,
                'top_img' => $item->top_img,
                'media_type' => $item->media_type,
                'price' => $item->price,
                'zan_count' => (int)$item->zan_count,
                'is_zan' => $item->isUpVotedBy(\Auth::guard('api')->id()),
                'status' => (int)$item->status == 2 ? '待审核' : ($item->status == 1 ? '已通过' : '未通过'),
                'created_at' => $item->created_at->toDateTimeString(),
                'user' => $item->userBrief(),
            ];
        }

        //当前用户为自己时拥有权限查看 或免费
        if (\Auth::guard('api')->id() === $item->user_id || $item->price === '0.00') {
            $this->permission = true;
        }
        $data = [
            'id' => $item->id,
            'title' => $item->title,
            'top_img' => $item->top_img,
            'media_type' => $item->media_type,
            'price' => $item->price,
            'zan_count' => (int)$item->zan_count,
            'is_zan' => $item->isUpVotedBy(\Auth::guard('api')->id()),
            'status' => (int)$item->status == 2 ? '待审核' : ($item->status == 1 ? '已通过' : '未通过'),
            'created_at' => $item->created_at->toDateTimeString(),
            'permission' => $this->permission,
            'body' => $this->permission ? $item->body : '',
            'media_url' => $this->permission ? (string)$item->media_url : '',
            'multi_imgs' => $this->permission ? $item->multi_imgs : [],
            'user' => $item->userBrief(),
            'tags' => $item->getTags(),
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