<?php

namespace App\Http\Requests;


class OrderRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'type' => 'required|in:chapter,article,course,vip',
            'pay_method' => 'required|in:alipay,wechat',
            'copper' => 'numeric|min:0|max:' . \Auth::guard('api')->user()->copper
        ];

        if ($this->type == 'chapter') {
            $rules['type_id'] = 'required|exists:chapters,id';
        } elseif ($this->type == 'article') {
            $rules['type_id'] = 'required|exists:articles,id';
        } elseif ($this->type == 'course') {
            $rules['type_id'] = 'required|exists:courses,id';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'type.in' => '错误的购买类型',
            'pay_method.' => '仅支持微信支付宝购买',
            'type_id.exists' => 'id不存在',
            'copper.max' => '不能超过当前铜币'
        ];
    }
}
