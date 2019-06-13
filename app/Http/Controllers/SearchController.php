<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $q = isset($request->q) ? trim($request->q) : '';
        $page = (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1;

        return view('pages.search.user', ['q' => $q, 'page' => $page]);
    }

    public function searchSong(Request $request)
    {
        $source = (isset($request->source) && $request->source >= 0 && $request->source <= 1) ? $request->source : 0;
        $q = isset($request->q) ? trim($request->q) : '';
        $page = (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1;

        return view('pages.search.song', ['source' => $source, 'q' => $q, 'page' => $page]);
    }
}
