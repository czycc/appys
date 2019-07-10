<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class Request extends FormRequest
{
    public function authorize()
    {
    	// Using policy for Authorization
        return true;
    }
}
