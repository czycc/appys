<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['courses', 'shop', 'audio', 'video', 'topic'];

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

    public function includeShop(Tag $item)
    {
        return $this->collection($item->users, new UserTransformer());
    }

    /**
     * @param Tag $item
     * @return \League\Fractal\Resource\Collection
     *
     * 包含用户音频
     */
    public function includeAudio(Tag $item)
    {
        return $this->collection($this->getArticles($item, 'audio'), new ArticleTransformer());
    }

    /**
     * @param Tag $item
     * @return \League\Fractal\Resource\Collection
     * 包含用户视频
     */
    public function includeVideo(Tag $item)
    {
        return $this->collection($this->getArticles($item, 'video'), new ArticleTransformer());
    }

    /**
     * @param Tag $item
     * @return \League\Fractal\Resource\Collection
     * 包含用户文章
     */
    public function includeTopic(Tag $item)
    {
        return $this->collection($this->getArticles($item, 'topic'), new ArticleTransformer());
    }

    public function getArticles($item, $type)
    {
        return $item->articles()
            ->where('type', $type)
            ->where('status', 1)
            ->orderBy('zan_count', 'desc')
            ->limit(5)
            ->get();
    }
}