<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\CompanyPost;
use App\Models\Configure;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\ZanRequest;

class ZanController extends Controller
{
    public function store(ZanRequest $request)
    {
        //根据不同情景点赞
        switch ($type = $request->type) {
            case 'article':
                //点赞文章
                $item = Article::find($request->id);
                break;
            case 'course':
                $item = Course::find($request->id);
                break;
            case 'company_post':
                $item = CompanyPost::find($request->id);
                break;
            default:
                return $this->response->errorBadRequest('类型错误');

        }

        if ($request->handler == 'upvote') {
            //点赞

            //判断是否已经点赞
            if (!$this->user()->hasUpVoted($item)) {
                if (!$this->user()->hasDownVoted($item) && $type == 'article') {
                    //第一次点赞,并且对象是用户文章,发放铜币
                    $configure = Configure::first();
                    $item->user()->increment('copper', $configure->zan_copper);
                }
                //文章点赞数+1
                $item->increment('zan_count', 1);


                if ($type == 'article') {
                    //用户店铺总点赞数增加
                    $this->user()->shop()->increment('zan_count', 1);
                }

                $this->user()->upVote($item);
            }
        } else {
            //取消点赞

            //判断是否已经取消过点赞
            if (!$this->user()->hasDownVoted($item)) {
                $this->user()->downVote($item);
                $item->decrement('zan_count', 1);
                if ($type == 'article') {
                    //用户店铺总点赞数减少
                    $this->user()->shop()->decrement('zan_count', 1);
                }
            }
        }

        return $this->response->created();
    }

}
