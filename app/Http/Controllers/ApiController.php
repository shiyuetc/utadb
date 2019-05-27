<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class ApiController extends Controller
{
    public function publicTimeline()
    {
        $statuses = Status::with(['user', 'song'])->get();
        return response()->json($statuses);
    }
}
