<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user = null;

    public function __construct(Request $request)
    {
        $this->user = User::where('screen_name', $request->id)->first();
    }
    
    public function index($id)
    {
        if(is_null($this->user)) {
            return view('errors.404');
        }
        return view('pages.user', ['user' => $this->user]);
    }

    public function status($id, $state)
    {
        if(is_null($this->user)) {
            return view('errors.404');
        }
        
        return view('pages.user', ['user' => $this->user, 'state' => $state]);
    }
}
