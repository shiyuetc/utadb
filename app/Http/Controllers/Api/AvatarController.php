<?php

namespace App\Http\Controllers\Api;

use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends ApiController
{   
    /**
     * Get avatar path array from matched select category.
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(Request $request)
    {
        $this->QueryValidate($request, [
            'category' => 'required|string|between:1,20',
        ]);
        $response = Avatar::where('category', $request->category)->get();
        return response()->json($response)->setStatusCode(200);
    }

}
