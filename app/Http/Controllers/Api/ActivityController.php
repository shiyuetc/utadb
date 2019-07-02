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

    public function likeCreate(Request $request)
    {
        $result = Activity::likeCreate($request->activity_id);
        return response()->json($result);
    }

    public function likeDestroy(Request $request)
    {
        $result = Activity::likeDestroy($request->activity_id);
        return response()->json($result);
    }
}
