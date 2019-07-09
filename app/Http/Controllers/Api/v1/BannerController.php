<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        return $this->response->array(Banner::all());
    }
}
