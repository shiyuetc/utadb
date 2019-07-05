<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $response = [];
            if(Auth::user()->allStateCount() == 0) {
                $response['alert'] = ['type' => 'default', 'text' => 'まずは曲の検索からあなたの持ち歌を探しましょう'];
            }
            $response['exist_unconfirm_notification'] = Notification::existUnconfirm();
            return view('pages.home', $response);
        } else {
            return view('pages.welcome');
        }
    }
}
