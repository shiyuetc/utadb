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
            $exist_unconfirm_notification = Notification::existUnconfirm();
            return view('pages.home', ['exist_unconfirm_notification' => $exist_unconfirm_notification]);
        } else {
            return view('pages.welcome');
        }
    }
}
