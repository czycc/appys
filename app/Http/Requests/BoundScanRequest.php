<?php

namespace App\Http\Requests;

class BoundScanRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string|exists:users,phone'
        ];
    }

    public function messages()
    {
        return [
            'code.exists' => '用户不存在，请检查二维码是否有误'
        ];
    }
}
