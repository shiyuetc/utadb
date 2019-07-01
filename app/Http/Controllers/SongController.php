<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index($id)
    {
        $status = Song::lookSong($id);
        if(is_null($status)) {
            return view('errors.404');
        }
        return view('pages.song', ['status' => $status]);
    }
}
