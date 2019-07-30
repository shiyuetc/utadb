<?php

namespace App\Libraries\SongPuller\Requests;

class iTunesRequest extends BasicRequest 
{
    public $requestIndex = '0';

    public $directUrl = 'https://itunes.apple.com/';

    public $lookSongPath = 'lookup';

    public $lookArtistPath = 'lookup';

    public $searchSongPath = 'search';

    public $searchSongFromArtistPath = 'lookup';

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
            return $this->toSong(
                $this->requestIndex,
                $song["trackId"],
                $song["trackCensoredName"],
                (string)$song["artistId"],
                $song["artistName"],
                $song["artworkUrl60"],
                isset($song["previewUrl"]) ? $song["previewUrl"] : null
            );
        }
        return null;
    }

    public function lookArtist($id)
    {
        $parameter = [
			'country' => 'JP',
			'lang' => 'ja_jp',
			'media' => 'music',
            'entity' => 'song',
            "id" => $id,
			'limit' => '1'
        ];
        $songs = $this->toJson($this->getRequest($this->directUrl . $this->lookArtistPath, $parameter))['results'];
        foreach($songs as $song)
        {
            return $this->toArtist(
                $this->requestIndex,
                $id,
                $song["artistName"]
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
                $response[] = $this->toSong(
                    $this->requestIndex,
                    $song["trackId"],
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

    public function searchSongFromArtist($id, $page)
    {
        $response = [];
        $parameter = [
			'country' => 'JP',
			'lang' => 'ja_jp',
			'media' => 'music',
            'entity' => 'song',
            "id" => $id,
			'limit' => '20',
			'offset' => ($page - 1) * 20
        ];
        $songs = $this->toJson($this->getRequest($this->directUrl . $this->searchSongFromArtistPath, $parameter))['results'];
        foreach($songs as $song)
        {
            if(isset($song["trackId"])) {
                $response[] = $this->toSong(
                    $this->requestIndex,
                    $song["trackId"],
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
            $response[] = $this->toArtist(
                $this->requestIndex,
                (string)$artist["artistId"],
                $artist["artistName"]
            );
        }
        return $response;
    }

    public function getRanking()
    {
        $songs = $this->toJson($this->getRequest("https://rss.itunes.apple.com/api/v1/jp/itunes-music/top-songs/all/10/explicit.json"))['feed']['results'];
        foreach($songs as $song)
        {
            $response[] = $this->toSong(
                $this->requestIndex,
                $song["id"],
                $song["name"],
                (string)$song["artistId"],
                $song["artistName"],
                $song["artworkUrl100"],
                null
            );
        }
        return $response;
    }
}