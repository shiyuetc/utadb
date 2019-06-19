<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Avatar;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends ApiController
{   
    public function searchAvatar(Request $request)
    {
        $this->QueryValidate($request, [
            'category' => ApiRequestRules::getCategoryRule(),
        ]);
        $avatars = Avatar::search($request->category);
        return response()->json($avatars);
    }

    public function userList(Request $request)
    {
        $this->QueryValidate($request, [
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $users = User::search('', $request->page);
        return response()->json($users);
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
}
