<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfileSettingForm()
    {
        return view('pages.settings.profile');
    }
}
