<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Banner;
use App\Transformers\BannerTransformer;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    public function index()
    {
        return $this->response->collection(Banner::all(), new BannerTransformer());
    }
}
