<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\MediaRequest;
use App\Models\Media;
use App\Transformers\MediaTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store($type, MediaRequest $request, Media $media)
    {
        $user = $this->user();
        //根据不同场景处理不同逻辑
        switch ($type) {
            case 'avatar':
                $img = $request->file('file');
                $path = Storage::putFile("avatars/{$user->id}", $img);
                break;
            case 'article':
                $file = $request->file('file');
                $date = date('Ym/d', time());
                $path =Storage::putFile("articles/{$user->id}/{$date}", $file);
                break;
            case 'shop':
                $path = Storage::putFile("shops/{$user->id}", $request->file('file'));
                break;
            default:
                return $this->response->errorBadRequest('错误场景类别');
        }
        $media->user_id = $user->id;
        $media->type = $type;
        $media->media_url = Storage::url($path);
        $media->save();

        return $this->response
            ->item($media, new MediaTransformer())->setStatusCode(201);


    }
}
