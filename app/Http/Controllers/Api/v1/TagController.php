<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Tag;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return $this->response->collection(Tag::orderBy('post_count', 'desc')->get(), new TagTransformer());
    }

    public function show(Tag $tag)
    {
        return $this->response->item($tag, new TagTransformer());
    }
}
