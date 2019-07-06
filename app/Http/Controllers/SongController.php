<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index($id)
    {
        $song = Song::infomation($id);
        if(is_null($song)) {
            return view('errors.404');
        }
        return view('pages.song', ['song' => $song]);
    }
}
