<?php

namespace App\Http\Requests;

class MediaRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
//            'media_type' => 'required|string|in:image,audio,video',
        ];
        if ($this->type == 'avatar') {
            $rules['file'] = 'required|mimes:jpeg,png,jpg|dimensions:min_width:200,min_height:200';
        } elseif ($this->type == 'shop') {
            $rules['file'] = 'required|mimes:jpeg,png,jpg';
        } else {
            $rules['file'] = 'required|mimes:jpeg,png,jpg,audio/mpeg,audio/mpga,mp4,ogg';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => '图片清晰度不够,宽高不低于200px',
        ];
    }
}
