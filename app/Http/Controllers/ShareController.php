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
                $url = 'http://api.woheni99.com/CompanyArticleDetail?id=' . $id;
                break;
            default:
                abort(404);
        }

        if ($user_id) {
            $url .= User::find($user_id)->phone;
        }

        return redirect($url);


    }
}
