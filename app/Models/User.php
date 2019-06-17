<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'screen_name', 'name', 'description', 'stacked_count', 'training_count', 'mastered_count', 'profile_image_url', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email', 'password', 'remember_token', 'updated_at'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function allStateCount() 
    {
        return $this->stacked_count + $this->training_count + $this->mastered_count;
    }

    public static function updateProfile($name, $description, $avatar_id = null) {
        $user = auth()->user();
        $user->name = $name;
        $user->description = $description;
        if(isset($avatar_id)) {
            $avatar = Avatar::find($avatar_id);
            if(isset($avatar)) {
                $user->profile_image_url = env('APP_URL') . "/images/profile_image/{$avatar->category}/{$avatar->id}";
            }
        }
        $user->save();
        return true;
    }

    public static function updateEmail($email = null) {
        $user = auth()->user();
        $user->email = isset($email) ? $email : null;
        $user->save();
        return true;
    }

    public static function updatePassword($password) {
        $user = auth()->user();
        $user->password = bcrypt($password);
        $user->save();
        return true;
    }

    public static function search($q, $page = 1)
    {
        return User::where('screen_name', 'like', "%{$q}%")
            ->orWhere('name', 'like', "%{$q}%")
            ->skip(($page - 1) * 50)
            ->take(50)
            ->orderBy('mastered_count', 'desc')
            ->get();
    }
}
