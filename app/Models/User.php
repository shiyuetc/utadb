<?php

namespace App\Models;

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
        'screen_name', 'name', 'description', 'stacked_state_count', 'training_state_count', 'mastered_state_count', 'profile_image_url', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function allStateCount() 
    {
        return $this->stacked_state_count + $this->training_state_count + $this->mastered_state_count;
    }
}
