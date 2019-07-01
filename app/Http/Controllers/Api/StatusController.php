<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends ApiController
{   
    public function lookup(Request $request)
    {
        $this->QueryValidate($request, [
            'song_id' => ApiRequestRules::getSongIdRule(),
        ]);
        $response = Status::statusLookup($request->song_id);
        return response()->json($response);
    }

    public function update(Request $request)
    {
        $this->QueryValidate($request, [
            'song_id' => ApiRequestRules::getSongIdRule(),
            'state' => ApiRequestRules::getStateRule(),
        ]);
        $status = Status::statusUpdate($request->song_id, $request->state);
        return response()->json($status);
    }
}
