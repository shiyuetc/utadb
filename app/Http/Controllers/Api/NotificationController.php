<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;

class NotificationController extends ApiController
{   
    public function index(Request $request)
    {
        $notifications = Notification::select('notifications.id', 'notifications.sender_id', 'notifications.kind', 'notifications.created_at', DB::raw('posts.id as post_id'), 'posts.song_id')
            ->leftjoin('posts', function($join) {
                $join->where('notifications.kind', '=', 'like')
                    ->on('posts.id', '=', 'notifications.context_id');
            })
            ->where('receiver_id', auth()->id())
            ->with(['sender', 'post', 'song'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 既読済みにする
        Notification::where('receiver_id', auth()->id())
            ->where('confirm', '=', 0)
            ->update(['confirm' => 1]);

        return response()->json($notifications)->setStatusCode(200);
    }
}
