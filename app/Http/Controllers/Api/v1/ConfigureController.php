<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\ArticlePrice;
use App\Models\CompanyCategory;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use App\Models\Banner;

class ConfigureController extends Controller
{
    /**
     * @return mixed
     *
     * 首页栏目名称
     */
    public function menu()
    {
        $company_categories = CompanyCategory::select(['id', 'name'])
            ->where('level', 0)
            ->get();
        $course_categories = CourseCategory::select(['id', 'name'])
            ->get();
        return $this->response->array(
            ['data' => [
                'company_categories' => $company_categories,
                'course_categories' => $course_categories,
                'video' => '用户视频',
                'article_audio' => '用户文章/用户音频'
            ]]);
    }

    /**
     * @return mixed
     *
     * 返回用户可用文章价格
     */
    public function articlePrice()
    {
        $data = ArticlePrice::select('id', 'price')->get()->toArray();
        return $this->response->array([
            'data' => $data
        ]);
    }

    public function home()
    {
        $company_categories = CompanyCategory::select(['id', 'name'])
            ->where('level', 0)
            ->get();
        $course_categories = CourseCategory::select(['id', 'name'])
            ->get();
        $hots = Course::
//            ->select([
//                'id','title','body','banner','ori_price','now_price', 'view_count', 'buy_count','zan_count','recommend','category_id','category',
//            ])
            where('recommend', 1)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
        foreach ($hots as $hot) {
            $hot->buynote = $hot->buynote()->select('body')->first()->body;
            $hot->teacher = $hot->teacher()->select(['id', 'name', 'desc'])->first();
            $hot->tags = $hot->getTags();
            $hot->category = $hot->category()->select('name')->first()->name;
            $hot->crated_at = $hot->created_at->toDateTimeString();
            $hot->updated_at = $hot->updated_at->toDateTimeString();
        }
        return $this->response->array(
            [
                'data' =>
                    [
                        'menu' => [
                            'company_categories' => $company_categories,
                            'course_categories' => $course_categories,
                            'video' => '用户视频',
                            'article_audio' => '用户文章/用户音频'
                        ],
                        'banners' => Banner::select(['id', 'img_url', 'desc', 'type', 'type_id', 'order'])->get(),
                        'hots' => $hots,
                        'notify' => [
                            '这是一段通知，有问题请联系123456789'
                        ]
                    ]]);
    }
}
