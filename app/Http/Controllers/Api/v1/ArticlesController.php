<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\ArticlePrice;
use App\Models\Media;
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
            //查询审核痛过
            $query->where('status', 1);
        }

        //按标签查询
        if ($tag_id = $request->input('tag_id')) {
            //根据标签id查询
            $query->whereHas('tags', function ($query) use($tag_id){
                $query->where('id', $tag_id);
            });
        }

        if ($user_id = $request->user_id) {
            //查询指定用户店铺下通过审核的文章
            $query->where('user_id', $user_id)->where('status', 1);
        }
        if ($request->type) {
            //查询指定类型
            $query->where('type', $request->type);
        }

        $posts = orderByRequest($request, $query);

        return $this->response->paginator($posts, new ArticleTransformer(true));

    }

    public function show(Article $article)
    {
        return $this->response->item($article, new ArticleTransformer());
    }


    public function store(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $this->user()->id;
        $article->status = 2; //避免transformer返回null
        $article->top_img = json_decode($request->multi_imgs)[0];//第一张作为头图

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
        $this->authorize('update', $article);
        $article->update($request->all());

        return $this->response->item($article, new ArticleTransformer());
    }

    public function destroy(Article $article)
    {
        $this->authorize('destroy', $article);
        $article->delete();
        return $this->response->noContent();
    }
}