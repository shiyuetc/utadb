<?php

namespace App\Libraries\SongPuller;

class Puller 
{
    protected $useRequest = [
        'iTunes', 'Dam'
    ];

    public function getUsingClass($source_id)
    {
        $usingPath = 'App\\Libraries\\SongPuller\\Requests\\'. $this->useRequest[$source_id] .'Request';
        require_once($usingPath .'.php');
        return new $usingPath;
    }

    public function lookSong($song_id)
    {
        if(count($this->useRequest) <= $song_id[0]) return [];
        $class = $this->getUsingClass($song_id[0]);
        return $class->lookSong(ltrim($song_id, $song_id[0]));
    }

    public function searchSong($source_id, $q, $page = 1)
    {
        if(count($this->useRequest) <= $source_id) return [];
        $class = $this->getUsingClass($source_id);
        return $class->searchSong($q, $page);
    }

    public function searchArtist($source_id, $q, $page = 1)
    {
        if(count($this->useRequest) <= $source_id) return [];
        $class = $this->getUsingClass($source_id);
        return $class->searchArtist($q, $page);
    }

}