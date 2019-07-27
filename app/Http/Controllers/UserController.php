<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index(Request $request)
    {
        return view('pages.users.index', ['user' => $request->user]);
    }

    public function records(Request $request)
    {
        return view('pages.users.records', ['user' => $request->user]);
    }

    public function status(Request $request)
    {
        $stateArray = [
            'all' => ['index' => 0, 'jp' => '登録済みの曲', 'en' => 'all', 'icon-class' => 'fa fa-check'], 
            'stacked' => ['index' => 1, 'jp' => '気になる曲', 'en' => 'stacked', 'icon-class' => 'fa fa-check'], 
            'training' => ['index' => 2, 'jp' => '練習中の曲', 'en' => 'training', 'icon-class' => 'fas fa-graduation-cap'], 
            'mastered' => ['index' => 3, 'jp' => '習得済みの曲', 'en' => 'mastered', 'icon-class' => 'far fa-sticky-note'], 
        ];
        $response = [
            'user' => $request->user,
            'state' => $stateArray[$request->state],
            'page' => (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1,
            'q' => isset($request->q) ? urlencode(trim($request->q)) : ''
        ];
        return view('pages.users.status', $response);
    }

    public function common(Request $request)
    {
        if(auth()->id() == $request->user->id) {
            return redirect()->route('user', ['id' => auth()->user()->screen_name]);
        }
        $page = (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1;
        return view('pages.users.common', ['user' => $request->user, 'page' => $page]);
    }

    public function random(Request $request)
    {
        $status = Status::select('song_id')
            ->where('user_id', $request->user->id)
            ->where('state', 3)
            ->inRandomOrder()
            ->first();
        if(isset($status)) {
            return redirect()->route('song', ['id' => $status['song_id']]);
        } else {
            $alert = ['type' => 'danger', 'text' => '習得済みに登録されている曲が見つかりませんでした'];
            return view('pages.users.index', ['user' => $request->user, 'alert' => $alert]);
        }
    }
}
