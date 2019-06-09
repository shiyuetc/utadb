<?php

namespace App\Libraries\SongPuller\Requests;

class iTunesRequest extends BasicRequest 
{
    public $directUrl = 'https://itunes.apple.com/';

    public $lookSongPath = 'lookup';

    public $searchSongPath = 'search';

    public $searchArtistPath = 'search';

    public function lookSong($id)
    {
        $parameter = [
			'country' => 'JP',
			'lang' => 'ja_jp',
			'media' => 'music',
			'entity' => 'song',
			'id' => $id
        ];
        $song = $this->toJson($this->getRequest($this->directUrl . $this->lookSongPath, $parameter))['results'];
        if(count($song) == 1) {
            $song = $song[0];
            return $this->toSongModel(
                '0' . $song["trackId"],
                $song["trackCensoredName"],
                (string)$song["artistId"],
                $song["artistName"],
                $song["artworkUrl60"],
                isset($song["previewUrl"]) ? $song["previewUrl"] : null
            );
        }
        return null;
    }

    public function searchSong($q, $page)
    {
        $response = [];
        $parameter = [
			'country' => 'JP',
			'lang' => 'ja_jp',
			'media' => 'music',
			'entity' => 'song',
			'term' => $q,
			'limit' => '20',
			'offset' => ($page - 1) * 20
        ];
        $songs = $this->toJson($this->getRequest($this->directUrl . $this->searchSongPath, $parameter))['results'];
        foreach($songs as $song)
        {
            if(isset($song["trackId"])) {
                $response[] = $this->toSongModel(
                    '0' . $song["trackId"],
                    $song["trackCensoredName"],
                    (string)$song["artistId"],
                    $song["artistName"],
                    $song["artworkUrl60"],
                    isset($song["previewUrl"]) ? $song["previewUrl"] : null
                );
            }
        }
        return $response;
    }

    public function searchArtist($q, $page)
    {
        $parameter = [
			'country' => 'JP',
			'lang' => 'ja_jp',
			'media' => 'music',
			'entity' => 'musicArtist',
			'attribute' => 'artistTerm',
			'term' => $q,
			'limit' => '20',
			'offset' => ($page - 1) * 20
        ];
        $artists = $this->toJson($this->getRequest($this->directUrl . $this->searchArtistPath, $parameter))['results'];
        foreach($artists as $artist)
        {
            $response[] = $this->toArtistModel(
                (string)$artist["artistId"],
                $artist["artistName"]
            );
        }
        return $response;
    }

}