<?php

namespace App\Libraries\SongPuller\Requests;

class iTunesRequest extends BasicRequest 
{
    private const DIRECT_URL = 'https://itunes.apple.com/';
    
    public function searchSong($q, $page = 1)
    {
        $response = [];
        $data = [
			'country' => 'JP',
			'lang' => 'ja_jp',
			'media' => 'music',
			'entity' => 'song',
			'term' => $q,
			'limit' => '20',
			'offset' => ($page - 1) * 20
        ];
        $songs = $this->toJson($this->getRequest(self::DIRECT_URL . 'search', $data))['results'];
        foreach($songs as $song)
        {
            $response[] = $this->toSongModel(
                '0' . $song["trackId"],
                $song["trackCensoredName"],
                (string)$song["artistId"],
                $song["artistName"],
                $song["artworkUrl60"],
                isset($song["previewUrl"]) ? $song["previewUrl"] : null
            );
        }
        return $response;
    }
    
}