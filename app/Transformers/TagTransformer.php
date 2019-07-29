<?php

namespace App\Transformers;

use App\Models\Tag;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['company_posts', 'courses', 'shops', 'audios', 'videos', 'topics'];

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
        $query = $item->courses()
            ->list()
            ->where('show', 1)
            ->ordered()
            ->zan()
            ->limit(5)
            ->get();
        return $this->collection($query, new CourseTransformer(true));
    }

    public function includeShops(Tag $item)
    {
        $query = $item->shops()
            ->where('expire_at', '>', Carbon::now())
            ->orderByDesc('order')
            ->orderByDesc('zan_count')
            ->limit(5)
            ->get();
        return $this->collection($query, new ShopTransformer(true));
    }

    /**
     * @param Tag $item
     * @return \League\Fractal\Resource\Collection
     *
     * 包含用户音频
     */
    public function includeAudios(Tag $item)
    {
        return $this->collection($this->getArticles($item, 'audio'), new ArticleTransformer(true));
    }

    /**
     * @param Tag $item
     * @return \League\Fractal\Resource\Collection
     * 包含用户视频
     */
    public function includeVideos(Tag $item)
    {
        return $this->collection($this->getArticles($item, 'video'), new ArticleTransformer(true));
    }

    /**
     * @param Tag $item
     * @return \League\Fractal\Resource\Collection
     * 包含用户文章
     */
    public function includeTopics(Tag $item)
    {
        return $this->collection($this->getArticles($item, 'topic'), new ArticleTransformer(true));
    }

    public function includeCompanyPosts(Tag $item)
    {
        return $this->collection($item->CompanyPosts()
            ->orderBy('order', 'desc')
            ->orderBy('zan_count', 'desc')
            ->limit(5)
            ->get(), new CompanyPostTransformer(true));
    }

    /**
     * @param $item
     * @param $type
     * @return mixed
     *
     * 按类型查询
     */
    public function getArticles($item, $type)
    {
        return $item->articles()
            ->where('media_type', $type)
            ->where('status', 1)//审核通过
            ->orderBy('zan_count', 'desc')
            ->limit(5)
            ->get();
    }
}