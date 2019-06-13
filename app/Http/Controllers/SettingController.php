<?php

namespace App\Http\Controllers;

use App\Models\Deactivate;
use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateDeactiveRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showProfileSettingForm()
    {
        return view('pages.settings.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $result = User::updateProfile($request->name, $request->description, $request->avatar);
        if($result) {
            $alert = ['type' => 'success', 'text' => 'プロフィールの変更を保存しました'];
        } else {
            $alert = ['type' => 'danger', 'text' => 'プロフィールの変更に失敗しました'];
        }
        
        return view('pages.settings.profile', ['alert' => $alert]);
    }

    public function showPasswordSettingForm()
    {
        return view('pages.settings.password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result = User::updatePassword($request->password);
        if($result) {
            $alert = ['type' => 'success', 'text' => 'パスワードの変更を保存しました'];
        } else {
            $alert = ['type' => 'danger', 'text' => 'パスワードの変更に失敗しました'];
        }
        
        return view('pages.settings.password', ['alert' => $alert]);
    }
}
