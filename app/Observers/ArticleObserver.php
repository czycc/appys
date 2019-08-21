<?php

namespace App\Observers;

use App\Models\Article;
use App\Notifications\NormalNotify;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ArticleObserver
{
    public function creating(Article $article)
    {
        //
    }

    public function updated(Article $article)
    {
        if ($article->isDirty('status')) {
            if ($article->status != 2) {
                $article->user->msgNotify(new NormalNotify(
                    '作品审核通知',
                    $article->status == 1 ? "您的作品 {$article->title} 审核通过" : "您的作品 {$article->title} 未通过审核",
                    'article',
                    $article->id
                ));
            }

        }
    }

    public function deleting(Article $article)
    {
        $article->user->msgNotify(new NormalNotify(
            '作品被删除通知',
            "您的作品 {$article->title} 已被删除",
            'article'
        ));
    }
}