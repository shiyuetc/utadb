<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{   
    public function list(Request $request)
    {
        $this->QueryValidate($request, [
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $users = User::search('', $request->query('page', 1));
        return response()->json($users);
    }

    public function search(Request $request)
    {
        $this->QueryValidate($request, [
            'q' => ApiRequestRules::getQRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $users = User::search($request->q, $request->query('page', 1));
        return response()->json($users);
    }
}
