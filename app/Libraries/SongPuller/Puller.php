<?php

namespace App\Libraries\SongPuller;

use App\Libraries\SongPuller\Requests\iTunesRequest;
use App\Libraries\SongPuller\Requests\DamRequest;

class Puller 
{
    protected static $useRequest = [
        'iTunes', 'Dam'
    ];

    public static function getUsingClass($source_id)
    {
        $usingPath = 'App\\Libraries\\SongPuller\\Requests\\' . self::$useRequest[$source_id] . 'Request';
        return new $usingPath;
    }

    public static function lookSong($song_id)
    {
        if(count(self::$useRequest) <= $song_id[0]) return null;
        $class = self::getUsingClass($song_id[0]);
        return $class->lookSong(substr($song_id, 1, strlen($song_id)-1));
    }

    public static function searchSong($source_id, $q, $page = 1)
    {
        if(count(self::$useRequest) <= $source_id) return [];
        $class = self::getUsingClass($source_id);
        return $class->searchSong($q, $page);
    }

    public static function searchSongFromArtist($artist_id, $page)
    {
        if(count(self::$useRequest) <= $artist_id[0]) return null;
        $class = self::getUsingClass($artist_id[0]);
        return $class->searchSongFromArtist(substr($artist_id, 1, strlen($artist_id)-1), $page);
    }

    public static function searchArtist($source_id, $q, $page = 1)
    {
        if(count(self::$useRequest) <= $source_id) return [];
        $class = self::getUsingClass($source_id);
        return $class->searchArtist($q, $page);
    }

}