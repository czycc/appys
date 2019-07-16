<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\AttentionRequest;
use App\Models\Attention;
use App\Transformers\AttentionTransformer;
use Encore\Admin\Form\Field\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttentionController extends Controller
{

    public function index(Request $request, Attention $attention)
    {
        $query = $attention->query();
        $userId = $this->user()->id;
        $query->where('user_id', $userId);
        $attentions = orderByRequest($request, $query);
        return $this->response->paginator($attentions, new AttentionTransformer());
    }

    public function store(AttentionRequest $request, Attention $attention)
    {
        $userId = $this->user()->id;
        $to_user_id = $request->to_user_id;
        if ($userId == $to_user_id) {
            return $this->response->errorBadRequest('关注自己啦');
        }
        $attention->user_id = $userId;
        $attention->to_user_id = $to_user_id;
        $attention->save();

        return $this->response->created();
    }

    public function destroy($to_user_id)
    {
        $userId = $this->user()->id;
        Attention::where('user_id', $userId)->where('to_user_id', $to_user_id)->delete();

        return $this->response->noContent();
    }
}
