<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Libraries\SongPuller\Puller;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index($id)
    {
        if(is_null($artist = Puller::lookArtist($id))) {
            return view('errors.404');
        }
        return view('pages.artist', ['artist' => new Artist($artist['artist_id'], $artist['artist'])]);
    }
}
