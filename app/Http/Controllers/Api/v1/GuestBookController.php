<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\GuestBookRequest;
use App\Models\GuestBook;
use App\Models\User;
use App\Transformers\GuestBookTransformer;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{

    /**
     * @param User $user
     * @return mixed
     *
     * 按用户id查询留言
     */
    public function show(User $user)
    {
        $guestBooks = GuestBook::select(['id', 'user_id', 'guest_id', 'guest_book_id', 'body', 'created_at'])
            ->where('user_id', $user->id)
            ->where('guest_book_id', 0)
            ->orderByDesc('id')
            ->paginate(20);

        return $this->response->paginator($guestBooks, new GuestBookTransformer());
    }

    /**
     * @param GuestBookRequest $request
     * @param GuestBook $item
     * @return \Dingo\Api\Http\Response
     *
     *
     */
    public function store(GuestBookRequest $request, GuestBook $item)
    {
        $item->fill($request->all());
        $item->guest_id = $this->user()->id;
        $item->save();

        return $this->response->created();
    }
}
