<?php

namespace App\Libraries\SongPuller\Requests;

use Exception;

class BasicRequest 
{
    public $directUrl = '';

    public $lookSongPath = '';

    public $searchSongPath = '';

    public $searchArtistPath = '';

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

    public function postRequest($url, $parameter = [])
    {
        $response = [];
		try {
            $data = http_build_query($parameter, '', '&');
            $context = [
                'http' => [
                    'method' => 'POST',
                    'header'  => implode("\r\n", array('Content-Type: application/x-www-form-urlencoded', 'Content-Length: ' . strlen($data))),
                    'content' => $data
                ],
            ];
            $response = file_get_contents($url, false, stream_context_create($context));
		} catch (Exception $e) { }
		return $response;
    }

    public function toJson($html)
	{
		return json_decode(mb_convert_encoding($html, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'), true);
    }
    
    public function toSongModel($id, $title, $artistId, $artist, $imageUrl = null, $audioUrl = null)
    {
        return [
            'id' => $id,
            'title' => $title,
            'artist_id' => $artistId,
            'artist' => $artist,
            'image_url' => $imageUrl,
            'audio_url' => $audioUrl,
        ];
    }

    public function toArtistModel($artistId, $artist)
    {
        return [
            'artist_id' => $artistId,
            'artist' => $artist,
        ];
    }
    
}