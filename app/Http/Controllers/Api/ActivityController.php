<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends ApiController
{
    public function userTimeline(request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
        ]);
        $activities = Activity::getTimeline($request->id, $request->next);
        return response()->json($activities);
    }

    public function publicTimeline(request $request)
    {
        $activities = Activity::getTimeline(null, $request->next);
        return response()->json($activities);
    }
}
