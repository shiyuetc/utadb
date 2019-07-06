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
        $users = User::take(50)
            ->orderBy('mastered_count', 'desc')
            ->get();
        return response()->json($users);
    }

    public function search(Request $request)
    {
        $this->QueryValidate($request, [
            'q' => ApiRequestRules::getQRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        $users = User::where('screen_name', 'like', "%{$request->q}%")
            ->orWhere('name', 'like', "%{$request->q}%")
            ->skip(($request->query('page', 1) - 1) * 50)
            ->take(50)
            ->orderBy('mastered_count', 'desc')
            ->get();
        return response()->json($users);
    }
}
