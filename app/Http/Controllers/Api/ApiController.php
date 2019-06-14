<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{   
    public function QueryValidate($request, $validate = null)
    {
        $validator = Validator::make($request->all(), $validate);
        if($validator->fails()) {
            $response['errors']  = current(array_slice($validator->errors()->toArray(), 0, 1, true))[0];
            throw new HttpResponseException(response()->json($response, 422));
        }
    }
}
