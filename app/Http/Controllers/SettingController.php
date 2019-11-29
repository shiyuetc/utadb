<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Deactivate;
use App\Models\Status;
use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateDeactiveRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showProfileSettingForm()
    {
        return view('pages.settings.profile');
    }

    public function showAccountSettingForm()
    {
        $response['isApplied'] = Deactivate::where('user_id', auth()->user()->id)->exists();
        return view('pages.settings.account', $response);
    }

    public function showOtherSettingForm()
    {
        return view('pages.settings.other');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->description = $request->description;
        if(isset($request->avatar)) {
            $avatar = Avatar::find($request->avatar);
            if(isset($avatar)) {
                $user->profile_image_url = env('APP_URL') . "/images/profile_image/{$avatar->category}/{$avatar->id}";
            }
        }
        $result = $user->save();
        return redirect()->route('settings.profile')
            ->with($result ? 'status' : 'error', 
                __($result ? "プロフィールの変更を保存しました" : 'プロフィールの変更に失敗しました'));
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $user = auth()->user();
        $user->email = $request->email;
        $result = $user->save();
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "メールアドレスの変更を保存しました" : 'メールアドレスの変更に失敗しました'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $result = $user->save();
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "パスワードの変更を保存しました" : 'パスワードの変更に失敗しました'));
    }

    public function updateDeactivate(UpdateDeactiveRequest $request)
    {
        $result = Deactivate::insert(['user_id' => auth()->user()->id]);
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "アカウントの削除申請を受け付けました" : 'アカウントの削除申請に失敗しました'));
    }

    public function updateUndeactivate(UpdateDeactiveRequest $request)
    {
        $result = Deactivate::where('user_id', auth()->user()->id)->delete();
        return redirect()->route('settings.account')
            ->with($result ? 'status' : 'error', 
                __($result ? "アカウントの削除申請を解除しました" : 'アカウントの削除申請の解除に失敗しました'));
    }

    public function export(Request $request)
    {
        $data = [];
        $state = $request->query('state', 0);
        if(!is_numeric($state) || $state > 3 || $state < 0) $state = 0;
        $sort = $request->query('sort', 'artist_asc');

        $query = Status::select('statuses.song_id')
            ->where('statuses.user_id', auth()->user()->id);

        if($state != 0) $query = $query->where('statuses.state', $state);

        switch($sort) {
            default:
                $query = $query->orderBy('artist', 'asc');
                break;
            case 'artist_desc':
                $query = $query->orderBy('artist', 'desc');
                break;
            case 'title_asc':
                $query = $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query = $query->orderBy('title', 'desc');
                break;
        }
        
        $temp_response = $query
            ->with('song')
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->limit(10000)
            ->get();

        foreach($temp_response as $temp) {
            $data[] = $temp->song;
        }

        return view('pages.export', ['data' => $data]);
    }
}
