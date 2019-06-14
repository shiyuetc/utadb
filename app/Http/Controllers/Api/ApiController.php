<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequestRules;
use App\Models\Avatar;
use App\Models\Status;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

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

    public function searchAvatar(Request $request)
    {
        $this->QueryValidate($request, [
            'category' => ApiRequestRules::getCategoryRule(),
        ]);
        $avatars = Avatar::search($request->category);
        return response()->json($avatars);
    }

    public function searchUser(Request $request)
    {
        $this->QueryValidate($request, [
            'q' => ApiRequestRules::getQRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $users = User::search($request->q, $request->page);
        return response()->json($users);
    }

    public function searchSong(Request $request)
    {
        $this->QueryValidate($request, [
            'source' => ApiRequestRules::getSourceRule(),
            'q' => ApiRequestRules::getQRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $statuses = Status::searchSong($request->source, $request->q, $request->page);
        return response()->json($statuses);
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
