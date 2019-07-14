<?php

namespace App\Observers;

use App\Models\Article;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ArticleObserver
{
    public function creating(Article $article)
    {
        //
    }

    public function updating(Article $article)
    {
        //
    }
}