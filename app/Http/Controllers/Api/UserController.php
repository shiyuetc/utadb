<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{   
    public function index(Request $request)
    {
        $this->QueryValidate($request, [
            'keyword' => 'sometimes|string|between:1,20',
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,50',
        ]);

        $keyword = $request->query('keyword', null);
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 50);

        $query = User::skip(($page - 1) * $per_page)
            ->take($per_page);

        if(!is_null($keyword)) {
            $query = $query->where('screen_name', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%");
        }

        $response = $query->orderBy('mastered_count', 'desc')
            ->get();

        return response()->json($response)->setStatusCode(200);
    }

}
