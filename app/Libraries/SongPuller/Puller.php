<?php

namespace App\Libraries\SongPuller;

class Puller 
{
    protected $useRequest = [];

    public function searchSong($source_id, $q, $page = 1)
    {
        if(count($this->useRequest) <= $source_id) return [];
        $requestPath = 'App\\Libraries\\SongPuller\\Requests\\'. $this->useRequest[$source_id] .'Request';
        require_once($requestPath .'.php');
        $class = new $requestPath;
        return $class->searchSong($q, $page);
    }

}