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
        $stateArray = [
            'all' => ['index' => 0, 'jp' => '登録済みの曲', 'en' => 'all'], 
            'stacked' => ['index' => 1, 'jp' => '気になる曲', 'en' => 'stacked'], 
            'training' => ['index' => 2, 'jp' => '練習中の曲', 'en' => 'training'], 
            'mastered' => ['index' => 3, 'jp' => '習得済みの曲', 'en' => 'mastered'], 
        ];
        return view('pages.user-status', ['user' => $this->user, 'state' => $stateArray[$state]]);
    }
}
