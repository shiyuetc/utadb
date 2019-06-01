<?php

namespace App\Libraries\SongPuller\Requests;

use Exception;

class BasicRequest 
{
    public function getRequest($url, $data = [])
	{
		$response = [];
		try {
			$context = [
				'http' => ['method' => 'GET'],
			];
			$requestUrl = $url . '?' . http_build_query($data, '', '&');
			$response = file_get_contents($requestUrl, false, stream_context_create($context));
		} catch (Exception $e) { }
		return $response;
	}

	public function toJson($html)
	{
		return json_decode(mb_convert_encoding($html, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'), true);
	}
}