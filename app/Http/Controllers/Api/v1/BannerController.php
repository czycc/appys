<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Banner;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    public function index()
    {
        return $this->response->array(Banner::all());
    }
}
