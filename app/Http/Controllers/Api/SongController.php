<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends ApiController
{   
    public function search(Request $request)
    {
        $this->QueryValidate($request, [
            'source' => ApiRequestRules::getSourceRule(),
            'q' => ApiRequestRules::getQRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $statuses = Song::search($request->source, $request->q, $request->query('page', 1));
        return response()->json($statuses);
    }
    
    public function userCommon(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $statuses = Song::userCommon($request->id, $request->query('page', 1));
        return response()->json($statuses);
    }

    public function userStatuses(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
            'state' => ApiRequestRules::getStateRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $statuses = Song::userStatuses($request->id, $request->state, $request->query('page', 1), $request->q);
        return response()->json($statuses);
    }
}
