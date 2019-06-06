<?php

namespace App\Http\Controllers;

use App\Libraries\SongPuller\Puller;
use App\Models\Song;
use App\Models\Status;
use Illuminate\Http\Request;

class SongController extends Controller
{
    private $song = null;

    public function __construct(Request $request)
    {
        $this->song = Puller::lookSong($request->id);
    }
    
    public function index($id)
    {
        if(is_null($this->song)) {
            return view('errors.404');
        }
        $this->song = Song::CreateSong($this->song["id"], $this->song["title"], $this->song["artist"], $this->song["image_url"], $this->song["audio_url"]);
        $this->song->user_state = Status::showStatus($this->song["id"])->user_state;
        return view('pages.song', ['song' => $this->song]);
    }
}
