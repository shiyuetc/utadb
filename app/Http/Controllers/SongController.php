<?php

namespace App\Http\Controllers;

use App\Libraries\SongPuller\Puller;
use App\Models\Song;
use App\Models\Status;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index($id)
    {
        $status = Status::showStatus($id);
        if(is_null($status)) {
            return view('errors.404');
        }
        return view('pages.song', ['status' => $status]);
    }

    public function search(Request $request)
    {
        $source = (isset($request->source) && $request->source >= 0 && $request->source <= 1) ? $request->source : 0;
        $q = isset($request->q) ? trim($request->q) : '';
        $page = (isset($request->page) && $request->page >= 1 && $request->page <= 9999) ? $request->page : 1;

        return view('pages.search.song', ['source' => $source, 'q' => $q, 'page' => $page]);
    }
}
