<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\ArticlePrice;
use App\Models\Media;
use App\Models\Order;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, Article $article)
    {
        $query = $article->query();

        if (!is_null($request->input('status'))) {
            //按状态查询，只针对当前用户
            $query->where('user_id', $this->user()->id)
                ->where('status', $request->input('status'));
        } else {
            //查询审核通过
            $query->where('status', 1);
        }

        //按标签查询
        if ($tag_id = $request->input('tag_id')) {
            //根据标签id查询
            $query->whereHas('tags', function ($query) use ($tag_id) {
                $query->where('id', $tag_id);
            });
        }

        if ($user_id = $request->user_id) {
            //查询指定用户店铺下通过审核的文章
            $query->where('user_id', $user_id);
        }
        if ($request->media_type) {
            //查询指定类型
            $query->where('media_type', $request->media_type);
        }

        $posts = orderByRequest($request, $query);

        return $this->response->paginator($posts, new ArticleTransformer(true));

    }

    public function show(Article $article)
    {
        $permission = false;
        //查询用户是否购买了课程
        if (
        Order::where('user_id', $this->user()->id)
            ->where('type_id', $article->id)
            ->whereIn('type', ['audio', 'video', 'topic'])
            ->whereNotNull('paid_at')
            ->first()
        ) {
            $permission = true;
        }

        return $this->response->item($article, new ArticleTransformer(false, $permission));
    }


    public function store(ArticleRequest $request, Article $article)
    {
        if ($this->user()->vip == '铜牌会员') {
            //未注册vip
            return $this->response()->errorBadRequest('需要成为银牌会员或代理会员才可以发布文章和申请店铺');
        }
        $article->fill($request->all());
        $multi = json_decode($request->multi_imgs);
        $article->user_id = $this->user()->id;
        $article->status = 2; //避免transformer返回null
        $article->top_img = $multi[0];//第一张作为头图
        $article->multi_imgs = $multi;
        //根据后台设置价格
        $price = ArticlePrice::find($request->price_id);
        $article->price = $price->price;
        $article->save();

        if ($request->tags) {
            $article->tags()->attach(json_decode($request->tags));
        }
        return $this->response
            ->item($article, new ArticleTransformer())
            ->setStatusCode(201);
    }

    public function update(ArticleRequest $request, Article $article)
    {
//        $this->authorize('update', $article);
        if ($this->user()->id !== $article->user_id) {
            return $this->response->errorBadRequest('不可以编辑他人文章');
        }
        $article->update($request->all());

        return $this->response->item($article, new ArticleTransformer());
    }

    public function destroy(Article $article)
    {
        if ($this->user()->id !== $article->user_id) {
            return $this->response->errorBadRequest('不可以删除他人文章');
        }
        $article->delete();
        return $this->response->noContent();
    }
}