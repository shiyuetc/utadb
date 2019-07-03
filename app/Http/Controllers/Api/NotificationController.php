<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{   
    public function list(Request $request)
    {
        $notifications = Notification::get();
        return response()->json($notifications);
    }
}
