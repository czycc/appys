<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index()
    {
        return $this->response->array(Tag::select(['id', 'name', 'post_count'])->get());
    }
}
