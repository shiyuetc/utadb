<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdatePasswordRequest;
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

    public function showPasswordSettingForm()
    {
        return view('pages.settings.password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $password = User::select('password')->find(auth()->user()->id);
        if(!password_verify($request->password_old, $password["password"])) {
            $alert = ['type' => 'danger', 'text' => '現在のパスワードが一致しませんでした'];
        } else {
            $result = User::updatePassword($request->password);
            if($result) {
                $alert = ['type' => 'success', 'text' => 'パスワードの変更を保存しました。'];
            } else {
                $alert = ['type' => 'danger', 'text' => 'パスワードの変更に失敗しました。'];
            }
        }
        
        return view('pages.settings.password', ['alert' => $alert]);
    }
}
