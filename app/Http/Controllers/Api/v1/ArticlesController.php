<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
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

        if ($request->type) {
            //查询指定类型
            $query->where('type', $request->type);
        }

        $posts = orderByRequest($request, $query);

        return $this->response->paginator($posts, new ArticleTransformer());

	}

    public function show(Article $article)
    {
        return $this->response->item($article, new ArticleTransformer());
    }


	public function store(ArticleRequest $request, Article $article)
	{
	    $article->fill($request->all());
	    $article->user_id = $this->user()->id;
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