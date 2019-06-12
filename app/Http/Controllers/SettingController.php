<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function updateProfile(Request $request)
    {
        $result = User::updateProfile($request->name, $request->description, $request->avatar);
        if($result) {
            $alert = ['type' => 'success', 'text' => 'プロフィールの変更を保存しました。'];
        } else {
            $alert = ['type' => 'danger', 'text' => 'プロフィールの変更に失敗しました。'];
        }
        
        return view('pages.settings.profile', ['alert' => $alert]);
    }
}
