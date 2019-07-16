<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\Course;
use App\Models\Material;
use App\Models\News;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZanController extends Controller
{
    public function store(Request $request)
    {
        //根据不同情景点赞
        switch ($request->type) {
            case 'article':
                //点赞文章
                $item = Article::find($request->id);
                break;
            case 'course':
                $item = Course::find($request->id);
                break;
            case 'material':
                $item = Material::find($request->id);
                break;
            case 'news':
                $item = News::find($request->id);
                break;
            default:
                return $this->response->errorBadRequest();

        }
        if ($this->user()->hasUpVoted($item)) {
            return $this->response->errorBadRequest('已经点赞过啦！');
        }
        if (!$this->user()->hasDownVoted($item) && $request->type == 'article') {
            //第一次点赞,并且对象是用户文章,发放铜币
            $item->user()->increment('copper', 1);
        }
        $this->user()->upVote($item);
        $item->increment('zan_count', 1);
        if ($request->type == 'article') {
            //用户总点赞数增加
            $item->user()->increment('zan_count', 1);
        }
        return $this->response->created();
    }

    public function delete(Request $request)
    {
        //根据不同情景点赞
        switch ($request->type) {
            case 'article':
                //点赞文章
                $item = Article::find($request->id);
                break;
            case 'course':
                $item = Course::find($request->id);
                break;
            case 'material':
                $item = Material::find($request->id);
                break;
            case 'news':
                $item = News::find($request->id);
                break;
            default:
                return $this->response->errorBadRequest();

        }
        if ($this->user()->hasDownVoted($item)) {
            return $this->response->errorBadRequest('已经取消过点赞啦！');
        }
        if (!$this->user()->hasUpVoted($item)) {
            return $this->response->errorBadRequest('用户没有点赞啦！');
        }
        $this->user()->downVote($item);
        $item->decrement('zan_count', 1);
        if ($request->type == 'article') {
            //用户总点赞数减少
            $item->user()->decrement('zan_count', 1);
        }
        return $this->response->noContent();
    }
}
