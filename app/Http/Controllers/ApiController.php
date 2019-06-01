<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Libraries\SongPuller\Puller;
use Exception;

class ApiController extends Controller
{
    public function publicTimeline()
    {
        $statuses = Status::publicTimeline();
        return response()->json($statuses);
    }
}
