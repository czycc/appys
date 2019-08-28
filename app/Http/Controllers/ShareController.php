<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CompanyPost;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShareController extends Controller
{
    public function share($type, $id, $user_id)
    {
        switch ($type) {
            case 'course':
                $url = 'http://api.woheni99.com/CourseDetail?id=' . $id;
                break;
            case 'article':
                $url = 'http://api.woheni99.com/UserArticleDetail?id=' . $id;
                break;
            case 'company_post':
                if ($user = User::find($user_id)) {
                    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5d2b37e7c2938683&redirect_uri=http://api.woheni99.com/CompanyArticleDetail?id={$id}&bound_id={$user->phone}&response_type=code&scope=snsapi_base&state=share";
                } else {
                    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5d2b37e7c2938683&redirect_uri=http://api.woheni99.com/CompanyArticleDetail?id={$id}&response_type=code&scope=snsapi_base&state=share";
                }
                return redirect($url);
                break;
            case 'shop':
                $url = 'http://api.woheni99.com/Shop?id=' . $id;
                break;
            default:
                abort(404);
        }

        if ($user = User::find($user_id)) {
            $url .= '&bound_id=' . $user->phone;
        }

        return redirect($url);


    }
}
