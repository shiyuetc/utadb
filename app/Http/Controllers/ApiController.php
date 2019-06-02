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

    public function publicTimeline()
    {
        $statuses = Status::publicTimeline();
        return response()->json($statuses);
    }
}
