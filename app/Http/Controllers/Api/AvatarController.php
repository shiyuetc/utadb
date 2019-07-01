<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends ApiController
{   
    public function search(Request $request)
    {
        $this->QueryValidate($request, [
            'category' => ApiRequestRules::getCategoryRule(),
        ]);
        $avatars = Avatar::search($request->category);
        return response()->json($avatars);
    }
}
