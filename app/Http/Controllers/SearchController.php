<?php

namespace App\Http\Controllers;

use App\Libraries\Rivision;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $response = [
            'q' => Rivision::q($request->q),
            'page' => Rivision::page($request->page)
        ];
        return view('pages.search.user', $response);
    }

    public function searchSong(Request $request)
    {
        $response = [
            'source' => (isset($request->source) && $request->source >= 0 && $request->source <= 1) ? $request->source : 0,
            'q' => Rivision::q($request->q),
            'page' => Rivision::page($request->page)
        ];
        return view('pages.search.song', $response);
    }
}
