<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }

    public function scopeZan($query)
    {
        return $query->orderBy('zan_count', 'desc');
    }

    public function ScopeViewed($query)
    {
        //按查看数量
        return $query->orderBy('view_count', 'desc');
    }
}
