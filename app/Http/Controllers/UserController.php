<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id)
    {
        $user = User::where('screen_name', $id)->first();
        if(!is_null($user)) {
            return view('pages.user', ['user' => $user]);
        } else {
            return view('errors.404');
        }
        
    }
}
