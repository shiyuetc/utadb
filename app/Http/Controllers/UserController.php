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

    public function status(Request $request, $id, $state)
    {
        if(is_null($this->user)) {
            return view('errors.404');
        }
        $page = (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1;
        $stateArray = [
            'all' => ['index' => 0, 'jp' => '登録済みの曲', 'en' => 'all', 'icon-class' => 'fa fa-check'], 
            'stacked' => ['index' => 1, 'jp' => '気になる曲', 'en' => 'stacked', 'icon-class' => 'fa fa-check'], 
            'training' => ['index' => 2, 'jp' => '練習中の曲', 'en' => 'training', 'icon-class' => 'fas fa-graduation-cap'], 
            'mastered' => ['index' => 3, 'jp' => '習得済みの曲', 'en' => 'mastered', 'icon-class' => 'far fa-sticky-note'], 
        ];
        return view('pages.user-status', ['user' => $this->user, 'state' => $stateArray[$state], 'page' => $page]);
    }

    public function search(Request $request)
    {
        $q = isset($request->q) ? trim($request->q) : '';
        $page = (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1;

        return view('pages.search-user', ['q' => $q, 'page' => $page]);
    }
}
