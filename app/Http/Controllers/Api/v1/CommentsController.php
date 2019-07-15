<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\Comment;
use App\Transformers\CommentTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function __construct()
    {
    }

	public function index(Request $request)
	{
        if ($request->user_id) {
            //查询用户id下的所有回复
            $user = User::find($request->user_id);
            $comments = $user->comments()->paginate(20);
        }elseif ($request->article_id) {
            //查询文章下所有回复
            $article = Article::find($request->article_id);
            $comments = $article->comments()->paginate(20);
        } else {
            return $this->response->array([]);
        }

        return $this->response->paginator($comments, new CommentTransformer());
	}

    public function show(Comment $comment)
    {
    }


	public function store(CommentRequest $request, Comment $comment)
	{
	    $comment->content = $request->input('content');
	    if ($request->comment_id) {
	        //回复评论
            $comment->comment_id = $request->comment_id;
        }
	    $article_id = $request->article_id;
	    if (empty($article_id)) {
	        $article_id = Comment::find($request->comment_id)->article_id;
        }
        $comment->article()->associate($article_id);

        $comment->user()->associate($this->user());
	    $comment->save();

	    return $this->response
            ->item($comment, new CommentTransformer())
            ->setStatusCode(201);
	}

	public function edit(Comment $comment)
	{
        $this->authorize('update', $comment);
		return view('comments.create_and_edit', compact('comment'));
	}

	public function update(CommentRequest $request, Comment $comment)
	{
		$this->authorize('update', $comment);
		$comment->update($request->all());

		return redirect()->route('comments.show', $comment->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Comment $comment)
	{
		$this->authorize('destroy', $comment);
		$comment->delete();

		return redirect()->route('comments.index')->with('message', 'Deleted successfully.');
	}
}