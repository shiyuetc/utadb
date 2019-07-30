<?php

namespace App\Libraries\SongPuller\Requests;

class DamRequest extends BasicRequest 
{
    public $requestIndex = '1';

    public $directUrl = 'https://www.clubdam.com/app/';

    public $lookSongPath = 'leaf/songKaraokeLeaf.html';

    public $lookArtistPath = 'leaf/artistKaraokeLeaf.html';

    public $searchSongPath = 'search/searchKeywordKaraoke.html';

    public $searchSongFromArtistPath = 'leaf/artistKaraokeLeaf.html';

    public $searchArtistPath = 'search/searchKaraokeKeywordArtist.html';

    public function lookSong($id)
    {
        $parameter = [
			'contentsId' => $id
        ];
        $doc = \phpQuery::newDocument($this->getRequest($this->directUrl . $this->lookSongPath, $parameter));
        $info = $doc["div#search01"];
        if(isset($info[0])) {
            $info = $info[0];
            preg_match("/[0-9]+/", pq($info)->find("td.singer a")->attr("href"), $artistId);
            return $this->toSong(
                $this->requestIndex,
                $id,
                pq($info)->find("p.artist")->text(),
                $artistId[0],
                pq($info)->find("td.singer")->text()
            );
        }
        return null;
    }

    public function lookArtist($id)
    {
        $parameter = [
            'artistCode' => $id
        ];
        $doc = \phpQuery::newDocument($this->getRequest($this->directUrl . $this->lookArtistPath, $parameter));
        $artist_name = $doc["p.artist"]->text();
        if(isset($artist_name)) {
            return $this->toArtist(
                $this->requestIndex,
                $id,
                $artist_name
            );
        }
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
			preg_match("/[0-9]+/", pq($row)->find("td:eq(0) a")->attr("href"), $songId);
            preg_match("/[0-9]+/", pq($row)->find("td:eq(1) a")->attr("href"), $artistId);
            $response[] = $this->toSong(
                $this->requestIndex,
                $songId[0],
                pq($row)->find("td:eq(0)")->text(),
                $artistId[0],
                pq($row)->find("td:eq(1)")->text()
            );
		}
        return $response;
    }

    public function searchSongFromArtist($id, $page)
    {
        $response = [];
        $parameter = [
            'artistCode' => $id,
            'pageNo' => $page
        ];
        $doc = \phpQuery::newDocument($this->getRequest($this->directUrl . $this->searchSongFromArtistPath, $parameter));
        $artist_name = $doc["p.artist"]->text();
        foreach($doc["table.list:eq(0) tr:not(:first)"] as $row) {
			preg_match("/[0-9]+/", pq($row)->find("td:eq(0) a")->attr("href"), $songId);
            $response[] = $this->toSong(
                $this->requestIndex,
                $songId[0],
                trim(pq($row)->find("td:eq(0)")->text()),
                $id,
                $artist_name
            );
		}
        return $response;
    }

    public function searchArtist($q, $page)
    {
        $response = [];
        $parameter = [
			'searchType' => '0',
			'keyword' => $q,
			'pageNo' => $page
        ];
        $doc = \phpQuery::newDocument($this->postRequest($this->directUrl . $this->searchArtistPath, $parameter));
        foreach($doc["table.list:eq(0) tr:not(:first)"] as $row) {
            preg_match("/[0-9]+/", pq($row)->find("td:eq(0) a")->attr("href"), $artistId);
            $response[] = $this->toArtist(
                $this->requestIndex,
                $artistId[0],
                pq($row)->find("td:eq(0)")->text()
            );
		}
        return $response;
    }

}