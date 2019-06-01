<?php

namespace App\Libraries\SongPuller\Requests;

use Exception;

class BasicRequest 
{
    public function getRequest($url, $parameter = [])
	{
		$response = [];
		try {
			$context = [
				'http' => ['method' => 'GET'],
			];
			$requestUrl = $url . '?' . http_build_query($parameter, '', '&');
			$response = file_get_contents($requestUrl, false, stream_context_create($context));
		} catch (Exception $e) { }
		return $response;
	}

    public function toJson($html)
	{
		return json_decode(mb_convert_encoding($html, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'), true);
    }
    
    public function toSongModel($id, $title, $artistId, $artist, $imageUrl = null, $audioUrl = null)
    {
        $object = [
            'id' => $id,
            'title' => $title,
            'artist_id' => $artistId,
            'artist' => $artist,
            'image_url' => $imageUrl,
            'audio_url' => $audioUrl,
        ];
        return $object;
    }

    public function toArtistModel($artistId, $artist)
    {
        $object = [
            'artist_id' => $artistId,
            'artist' => $artist,
        ];
        return $object;
    }
    
}