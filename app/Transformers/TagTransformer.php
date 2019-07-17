<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['courses', 'users', 'news', 'audio', 'video', 'topic'];

    public function transform(Tag $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'post_count' => (int)$item->post_count
        ];
    }

    public function includeCourses(Tag $item)
    {
        return $this->collection($item->courses, new CourseTransformer());
    }
    public function includeNews(Tag $item)
    {
        return $this->collection($item->news, new NewsTransformer());
    }
    public function includeUsers(Tag $item)
    {
        return $this->collection($item->users, new UserTransformer());
    }

    public function includeAudio(Tag $item)
    {
        return $this->collection($item->articles, new ArticleTransformer());
    }

    public function includeVideo(Tag $item)
    {
        return $this->collection($item->articles, new ArticleTransformer());
    }

    public function includeTopic(Tag $item)
    {
        return $this->collection($item->articles, new CourseTransformer());
    }
}