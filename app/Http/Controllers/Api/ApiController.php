<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{   
    /**
     * The function is exception proccessing exclusively for api request.
     * 
     * @param string $message
     * @param int $statusCode
     * @return void
     */
    public function CallException($message, $statusCode = 500)
    {
        $response['errors'] = $message;
        throw new HttpResponseException(response()->json($response, $statusCode));
    }

    /**
     * The function is query validation exclusively for api request.
     * 
     * @param Request $request
     * @param array $validate
     * @return void
     */
    public function QueryValidate($request, $validate)
    {
        $validator = Validator::make($request->all(), $validate);
        if($validator->fails()) {
            $this->CallException(current(array_slice($validator->errors()->toArray(), 0, 1, true))[0], 422);
        }
    }

}
