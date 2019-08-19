<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Article;
use App\Models\ArticlePrice;
use App\Models\CompanyCategory;
use App\Models\CompanyPost;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Shop;
use App\Transformers\CourseTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Redis;

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

        //热门推荐课程
        $hots = Course::with(['teacher' => function ($query) {
            $query->select(['id', 'name', 'desc']);
        }])->list()
            ->where('recommend', 1)
            ->orderBy('id', 'desc')
            ->limit(15)
            ->get();
        foreach ($hots as $hot) {
            $hot->body = make_excerpt($hot->body);
        }

        //最新资讯
        $news = CompanyPost::select(['id', 'title', 'body', 'thumbnail', 'category_id', 'created_at'])
            ->where('category_id', 2)//固定id为2
            ->orderByDesc('id')
            ->limit(15)
            ->get();
        foreach ($news as $new) {
            $new->body = make_excerpt($new->body);
            $new->category = $new->category()->first()->name;
        }

        //推荐店铺
        $shops = Shop::with(['user' => function ($query) {
            $query->select(['id', 'nickname', 'avatar']);
        }])
            ->select(['id', 'user_id', 'updated_at'])
            ->where('recommend', 1)
            ->orderByDesc('order')
            ->where('expire_at', '>', Carbon::now())
            ->orderBy('updated_at', 'desc')
            ->limit(15)
            ->get();


        //首页栏目名称
        $menu[0] = $course_categories[0]->name;
        $menu[1] = $course_categories[1]->name;
        $menu[2] = $course_categories[2]->name;
        $menu[3] = $course_categories[3]->name;
        $menu[4] = $company_categories[0]->name;
        $menu[5] = '用户文章/音频';
        $menu[6] = '用户视频';
        $menu[7] = $company_categories[1]->name;

        $notify = Redis::get('appys_index_notify');

        return $this->response->array(
            [
                'data' => [
                        'menu' => $menu,
                        'banners' => Banner::select(['id', 'img_url', 'desc', 'type', 'type_id'])
                            ->orderByDesc('order')
                            ->get(),
                        'shops' => $shops,
                        'hots' => $hots,
                        'news' => $news,
                        'notify' => json_decode($notify, true) ?? [],
                    ]]);
    }
}
