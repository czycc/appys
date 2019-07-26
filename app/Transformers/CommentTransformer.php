<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'article', 'replies'];

    public function transform(Comment $item)
    {
        return [
            'id' => $item->id,
            'user_id' => (int)$item->user_id,
            'article_id' => (int)$item->article_id,
            'content' => $item->content,
            'created_at' => $item->created_at->toDateTimeString(),
        ];
    }

    public function includeArticle(Comment $item)
    {
        return $this->item($item->article, new ArticleTransformer(true));
    }

    public function includeUser(Comment $item)
    {
        return $this->item($item->user, new UserTransformer(true));
    }

    public function includeReplies(Comment $item)
    {
        $replies = $item->replies()->orderByDesc('id')->get();

        return $this->collection($replies, new RepliesTransformer());
    }
}