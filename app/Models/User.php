<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

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
        'screen_name', 'name', 'description', 'record_count', 'stacked_count', 'training_count', 'mastered_count', 'following_count', 'follower_count', 'profile_image_url', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email', 'password', 'remember_token', 'updated_at'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

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

    public static function setData(&$user) 
    {
        if(auth()->check() && auth()->id() != $user->id) {
            // フレンド状態を取得
            $user->is_following = DB::table('friends')
                ->where('user_id', $user->id)
                ->where('following_id', auth()->id())
                ->exists();
            $user->is_following_you = DB::table('friends')
                ->where('user_id', auth()->id())
                ->where('following_id', $user->id)
                ->exists();

            // 共通曲のカウント
            $user->common_count = DB::table('statuses')
            ->select('statuses.song_id')
            ->join('statuses as s1', function($join) {
                $join->where('s1.user_id', auth()->id())
                ->where('s1.state', 3)
                ->on('statuses.song_id', '=', 's1.song_id');
            })
            ->where('statuses.user_id', $user->id)
            ->where('statuses.state', 3)
            ->count();
        }
    }
}
