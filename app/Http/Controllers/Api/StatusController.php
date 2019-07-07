<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends ApiController
{   
    public function edit(Request $request)
    {
        $this->QueryValidate($request, [
            'song_id' => ApiRequestRules::getSongIdRule(),
            'state' => ApiRequestRules::getStateRule(),
        ]);
        $status = Status::edit($request->song_id, $request->state);
        return response()->json($status);
    }

    public function lookup(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getSongIdRule(),
        ]);
        
        $response = [1 => [], 2 => [], 3 => []];
        $rows = Status::select('user_id', 'state')
            ->where('song_id', $request->id)
            ->orderBy('used_at', 'desc')
            ->with('user')
            ->get();
        foreach($rows as $row) {
            $response[(int)$row['state']][] = $row['user'];
        }
        return response()->json($response)->setStatusCode(200);
    }
}
