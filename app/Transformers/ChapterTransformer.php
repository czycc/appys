<?php

namespace App\Transformers;

use App\Models\Chapter;
use App\Models\Order;
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
        //判断有没有权限
        if ($item->price === 0 || \Auth::guard('api')->user()->vip !== '铜牌会员') {
            //免费
            $this->permission = true;
        }
        //查询是否购买过当前章节
        if (!$this->permission) {
            if (
            Order::where('user_id', \Auth::guard('api')->user()->id)
                ->where('type_id', $item->id)
                ->where('type', 'chapter')
                ->whereNotNull('paid_at')
                ->first()
            ) {
                $this->permission = true;
            }
        }
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