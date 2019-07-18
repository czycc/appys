<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Chapter;
use App\Transformers\ChapterTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\ChapterRequest;

class ChaptersController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function show(Chapter $chapter)
    {
        return $this->response->item($chapter, new ChapterTransformer());
    }

}