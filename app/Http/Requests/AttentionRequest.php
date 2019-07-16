<?php

namespace App\Http\Requests;


class AttentionRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'to_user_id' => 'required|exists:users,id'
        ];
    }
}
