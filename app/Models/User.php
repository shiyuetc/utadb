<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

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

    /**
     * The function for send custom email.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Return song count of registration.
     *
     * @return int
     */
    public function stateCount() 
    {
        return $this->stacked_count + $this->training_count + $this->mastered_count;
    }
    
}
