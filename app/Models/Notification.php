<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Notification extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'receiver_id', 'sender_id', 'activity_id', 'song_id'
    ];

    public function sender()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function activity()
    {
        return $this->belongsTo('App\Models\Activity');
    }

    public function song()
    {
        return $this->belongsTo('App\Models\Song');
    }

    public static function create($receiver_id, $context_id, $kind)
    {
        Notification::insert([
            'receiver_id' => $receiver_id,
            'sender_id' => auth()->id(),
            'context_id' => $context_id,
            'kind' => $kind
        ]);
    }

    public static function remove($receiver_id, $context_id)
    {
        Notification::where('receiver_id', $receiver_id)
            ->where('sender_id', auth()->id())
            ->where('context_id', $context_id)
            ->delete();
    }
    
    public static function get() {
        $notifications = Notification::select('notifications.id', 'notifications.sender_id', 'notifications.kind', 'notifications.created_at', DB::raw('activities.id as activity_id'), 'activities.song_id')
            ->leftjoin('activities', function($join) {
                $join->where('notifications.kind', '=', 'like')
                    ->on('activities.id', '=', 'notifications.context_id');
            })
            ->where('receiver_id', auth()->id())
            ->with(['sender', 'activity', 'song'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 既読済みにする
        Notification::where('receiver_id', auth()->id())
            ->where('confirm', '=', 0)
            ->update(['confirm' => 1]);
        return $notifications;
    }

    public static function existUnconfirm() {
        return Notification::where('receiver_id', auth()->id())
            ->where('confirm', '=', 0)
            ->exists();
    }
}
