<?php

namespace App\Http\Requests;

class ZanRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:article,company_post,news,course,material',
            'id' => 'required|integer'
        ];
    }
}