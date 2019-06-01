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
        return null;
    }

    public function searchSong($q, $page)
    {
        $response = [];
        $parameter = [
			'searchType' => '1',
			'keyword' => $q,
			'pageNo' => $page
        ];
        $doc = \phpQuery::newDocument($this->postRequest($this->directUrl . $this->searchSongPath, $parameter));
		foreach($doc["table.list:eq(0) tr:not(:first)"] as $row) {
			preg_match("/[0-9]+/", pq($row)->find("td:eq(0) a")->attr("href"), $song_id);
            preg_match("/[0-9]+/", pq($row)->find("td:eq(1) a")->attr("href"), $artist_id);
            
            $response[] = $this->toSongModel(
                '1' . $song_id[0],
                pq($row)->find("td:eq(0)")->text(),
                $artist_id[0],
                pq($row)->find("td:eq(1)")->text()
            );
		}
        return $response;
    }

    public function searchArtist($q, $page)
    {
        return null;
    }

}