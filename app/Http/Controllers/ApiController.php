<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StatusRequest;
use App\Models\Status;

class ApiController extends Controller
{   
    public function updateStatus(StatusRequest $request)
    {
        $update = Status::updateStatus($request->id, $request->state);
        return response()->json($update);
    }

    public function userTimeline(request $request)
    {
        $statuses = Status::getTimeline($request->id);
        return response()->json($statuses);
    }

    public function publicTimeline()
    {
        $statuses = Status::getTimeline();
        return response()->json($statuses);
    }
}
