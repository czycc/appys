<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Overtrue\LaravelFollow\Traits\CanBeVoted;

class CompanyPost extends Model
{
    use CanBeVoted;

    protected $fillable = ['title', 'body', 'thumbnail', 'media_type', 'is_notify', 'media_url', 'category_id', 'view_count', 'zan_count', 'weight'];
    public function category()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * 返回标签列表
     */
    public function getTags()
    {
        return $this->tags()->select(['id', 'name'])->get();
    }

    public function setThumbnailAttribute($thumbnail)
    {
        //用于后台上传保存完整地址
        if (!filter_var($thumbnail, FILTER_VALIDATE_URL)) {
            $this->attributes['thumbnail'] = Storage::url($thumbnail);
        } else {
            $this->attributes['thumbnail'] = $thumbnail;
        }
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function (CompanyPost $post) {
            if ($post->is_notify) {
                //发送通知
                $client = new \JPush\Client(config('services.jpush.app_key'), config('services.jpush.app_secret'), null);
                $push = $client->push();
                $push->setPlatform('all')
                    ->addAllAudience()
                    ->setNotificationAlert('新文章发布：' . $post->title)
                    ->androidNotification('新文章发布：' . $post->title, [
                        'intent' => [
                            'url' => 'intent:#Intent;component=com.ahaiba.keephealth/com.ahaiba.keephealth.mvvm.view.activity.ArticleDetailActivityNew;end'
                        ],
                        'large_icon' => 'https://woheniys.oss-cn-hangzhou.aliyuncs.com/logo.png',
                        'extras' => [
                            'id' => "{$post->id}"
                        ]
                    ])->iosNotification('新文章发布：' . $post->title, [
                        'extras' => [
                            'id' => $post->id,
                            'type' => 'company_post',
                            'title' => $post->title
                        ]
                    ]);
                $push->send();
            }
            DB::table('company_posts')->where('id', $post->id)->update([
                'is_notify' => 0
            ]);
        });
    }
}
