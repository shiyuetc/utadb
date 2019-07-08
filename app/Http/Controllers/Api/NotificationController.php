<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;

class NotificationController extends ApiController
{   
    public function list(Request $request)
    {
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

        return response()->json($notifications);
    }
}
