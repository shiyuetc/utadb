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
        $song = Puller::lookSong($id);
        if(is_null($song)) {
            return view('errors.404');
        }
        $song = Song::CreateSong($song["id"], $song["title"], $song["artist"], $song["image_url"], $song["audio_url"]);
        $song->user_state = Status::showStatus($song["id"])["user_state"];
        return view('pages.song', ['song' => $song]);
    }

    public function search(Request $request)
    {
        return view('pages.search-song', []);
    }
}
