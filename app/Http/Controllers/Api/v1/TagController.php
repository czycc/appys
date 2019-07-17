<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Tag;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index()
    {
        return $this->response->collection(Tag::all(), new TagTransformer());
    }

    public function show(Tag $tag)
    {
        return $this->response->item($tag, new TagTransformer());
    }
}
