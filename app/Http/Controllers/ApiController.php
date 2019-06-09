<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApiRequestRules;
use App\Models\Status;

class ApiController extends Controller
{   
    private function QueryValidate($request, $validate = null)
    {
        $validator = Validator::make($request->all(), $validate);
        if($validator->fails()) {
            $response['errors']  = current(array_slice($validator->errors()->toArray(), 0, 1, true))[0];
            throw new HttpResponseException(response()->json($response, 422));
        }
    }

    public function showStatus(Request $request)
    {
        $this->QueryValidate($request, [
            'song_id' => ApiRequestRules::getSongIdRule(),
        ]);
        $status = Status::showStatus($request->song_id);
        return response()->json($status);
    }

    public function updateStatus(Request $request)
    {
        $this->QueryValidate($request, [
            'song_id' => ApiRequestRules::getSongIdRule(),
            'state' => ApiRequestRules::getStateRule(),
        ]);
        $status = Status::updateStatus($request->song_id, $request->state);
        return response()->json($status);
    }

    public function searchSong(Request $request)
    {
        $statuses = Status::searchSong($request->source, $request->q, $request->page);
        return response()->json($statuses);
    }

    public function userStatuses(Request $request)
    {
        $statuses = Status::userStatuses($request->id, $request->state, $request->page);
        return response()->json($statuses);
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
