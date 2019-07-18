<?php

namespace App\Http\Requests;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Contracts\Validation\Validator;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
    public function authorize()
    {
    	// Using policy for Authorization
        return true;
    }

}
