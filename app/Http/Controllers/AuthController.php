<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request) 
    {
        $credentials = [
            'screen_name' => $request->input('screen_name'),
            'password' => $request->input('password')
        ];
        if (!$token = auth("api")->attempt($credentials)) {
            return $this->ExceptionResponse(401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => User::where('screen_name', $credentials['screen_name'])->get()
        ]);
    }
}
