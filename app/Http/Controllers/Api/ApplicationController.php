<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends ApiController
{   
    public function resourceCount()
    {
        return response()->json([
            'user_count' => User::count(),
            'activity_count' => Activity::count()
        ]);
    }
}
