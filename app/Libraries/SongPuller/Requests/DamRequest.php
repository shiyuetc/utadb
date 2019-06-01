<?php

namespace App\Libraries\SongPuller\Requests;

class DamRequest extends BasicRequest 
{
    public $directUrl = 'https://www.clubdam.com/app/';

    public $lookSongPath = 'leaf/songKaraokeLeaf.html';

    public $searchSongPath = 'search/searchKeywordKaraoke.html';

    public $searchArtistPath = 'search/searchKaraokeKeywordArtist.html';

    public function lookSong($id)
    {

    }

    public function searchSong($q, $page = 1)
    {

    }

    public function searchArtist($q, $page = 1)
    {

    }
    
}