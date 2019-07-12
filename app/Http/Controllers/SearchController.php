<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $response = [
            'q' => isset($request->q) ? urlencode(trim($request->q)) : '',
            'page' => (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1
        ];
        return view('pages.search.user', $response);
    }

    public function searchSong(Request $request)
    {
        $response = [
            'source' => (isset($request->source) && $request->source >= 0 && $request->source <= 1) ? $request->source : 0,
            'q' => isset($request->q) ? urlencode(trim($request->q)) : '',
            'page' => (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1
        ];
        return view('pages.search.song', $response);
    }
}
