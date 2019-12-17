<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;

class ApiController extends Controller
{
    protected $errors = [
        401 => 'Unauthorized.',
        500 => 'Internal Server Error.'
    ];

    public function ExceptionResponse($statusCode = 500, $message = null)
    {
        $response['errors']['message'] = is_null($message) ? $this->errors[$statusCode] : $message;
        throw new HttpResponseException(response()->json($response, $statusCode));
    }
}
