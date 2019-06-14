<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequestRules;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusesController extends ApiController
{   
    public function statusUpdate(Request $request)
    {
        $this->QueryValidate($request, [
            'song_id' => ApiRequestRules::getSongIdRule(),
            'state' => ApiRequestRules::getStateRule(),
        ]);
        $status = Status::statusUpdate($request->song_id, $request->state);
        return response()->json($status);
    }

    public function userCommon(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $statuses = Status::userCommon($request->id, $request->page);
        return response()->json($statuses);
    }

    public function userStatuses(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
            'state' => ApiRequestRules::getStateRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $statuses = Status::userStatuses($request->id, $request->state, $request->page);
        return response()->json($statuses);
    }

    public function userTimeline(request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
        ]);
        $statuses = Status::getTimeline($request->id);
        return response()->json($statuses);
    }

    public function publicTimeline()
    {
        $statuses = Status::getTimeline();
        return response()->json($statuses);
    }
}
