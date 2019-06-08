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
        return view('pages.search-song', []);
    }
}
