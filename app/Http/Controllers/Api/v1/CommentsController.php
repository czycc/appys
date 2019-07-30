<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\ReplyRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Reply;
use App\Transformers\CommentTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        if ($request->article_id) {
            //查询文章下所有回复
            $article = Article::find($request->article_id);
            $comments = $article->comments()->with('replies')
                ->orderBy('id', 'desc')->paginate(20);
        } else {
            //先查询用户下的所有文章id，再查询所有回复的id
            $articles = $this->user()->articles()->get()->pluck('id');
            $comments = Comment::whereIn('article_id', $articles)
                ->where('user_id', '!=', $this->user()->id)
                ->orderBy('id', 'desc')->paginate(20);
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

    /**
     * @param ReplyRequest $request
     * @return \Dingo\Api\Http\Response
     *
     * 回复评论
     */
    public function reply(ReplyRequest $request)
    {
        Reply::create([
            'content' => $request->input('content'),
            'user_id' => $this->user()->id,
            'comment_id' => $request->input('comment_id')
        ]);
        return $this->response->created();
    }
}