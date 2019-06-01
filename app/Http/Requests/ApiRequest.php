<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response['errors']  = current(array_slice($validator->errors()->toArray(), 0, 1, true))[0];
        throw new HttpResponseException(response()->json($response, 422));
    }
}
