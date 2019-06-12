<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPassword;

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

    public static function search($q, $page = 1)
    {
        return User::where('screen_name', 'like', "%{$q}%")
            ->orWhere('name', 'like', "%{$q}%")
            ->skip(($page - 1) * 50)
            ->take(50)
            ->get();
    }
}
