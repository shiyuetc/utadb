<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [];
    
    protected $hidden = [
        'artist_id', 'created_at'
    ];

    public static function CreateSong($id, $title, $artist, $image_url = null, $audio_url = null)
    {
        $song = new Song();
        $song->id = $id;
        $song->title = $title;
        $song->artist = $artist;
        $song->image_url = $image_url;
        $song->audio_url = $audio_url;
        return $song;
    }
}
