<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
