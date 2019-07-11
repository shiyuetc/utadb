<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends ApiController
{   
    /**
     * Return all user count and all post count.
     * 
     * @return array $response
     */
    public function resourceCount()
    {
        return response()->json([
            'user_count' => User::count(),
            'post_count' => Post::count()
        ])->setStatusCode(200);
    }

}
