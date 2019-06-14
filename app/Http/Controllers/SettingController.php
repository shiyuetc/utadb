<?php

namespace App\Http\Controllers;

use App\Models\Deactivate;
use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateDeactiveRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showAccountSettingForm()
    {
        return view('pages.settings.account', ['isApplied' => Deactivate::isApplied(auth()->user()->id)]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $result = User::updateProfile($request->name, $request->description, $request->avatar);
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "プロフィールの変更を保存しました" : 'プロフィールの変更に失敗しました'));
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $result = User::updateEmail($request->email);
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "メールアドレスの変更を保存しました" : 'メールアドレスの変更に失敗しました'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result = User::updatePassword($request->password);
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "パスワードの変更を保存しました" : 'パスワードの変更に失敗しました'));
    }

    public function updateDeactivate(UpdateDeactiveRequest $request)
    {
        $result = Deactivate::appli(auth()->user()->id);
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "アカウントの削除申請を受け付けました" : 'アカウントの削除申請に失敗しました'));
    }

    public function updateUndeactivate(UpdateDeactiveRequest $request)
    {
        $result = Deactivate::cancel(auth()->user()->id);
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "アカウントの削除申請を解除しました" : 'アカウントの削除申請の解除に失敗しました'));
    }
}
