<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    public function userTimeline(request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
        ]);
        $posts = Post::getTimeline($request->id, $request->next);
        return response()->json($posts)->setStatusCode(200);
    }

    public function publicTimeline(request $request)
    {
        $posts = Post::getTimeline(null, $request->next);
        return response()->json($posts)->setStatusCode(200);
    }
}
