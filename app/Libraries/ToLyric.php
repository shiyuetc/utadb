<?php

namespace App\Libraries;

class ToLyric
{
    public static function get($input_artist, $input_title)
    {
        $artist = str_replace(' ', '+', $input_artist);
        $title = str_replace(' ', '+', $input_title);
        $response = [];
        try {
            $html = file_get_contents("http://search.j-lyric.net/?ct=2&ca=2&cl=2&ka={$artist}&kt={$title}");
            $doc = \phpQuery::newDocument($html)->find("#mnb");
            $songs = [];
            foreach($doc["div.bdy"] as $bdy) {
                $artist = pq($bdy)->find("p.sml a")->text();
                $title = pq($bdy)->find("p.mid a")->text();
                $url = pq($bdy)->find("p.mid a")->attr("href");
                if ($title != "" && $artist != "") {
                    $songs[] = [
                        "title" => $title,
                        "artist" => $artist,
                        "url" => $url
                    ];
                } else {
                    break;
                }
            }
            if(count($songs) > 0) {
                foreach($songs as $song) {
                    if($song["artist"] == $input_artist && $song["title"] == $input_title) {
                        $response = $song;
                        break;
                    }
                }
                if(count($response) == 0) {
                    $response = $songs[0];
                }
                $html = file_get_contents($response["url"]);
                $doc = \phpQuery::newDocument($html)->find("#mnb");
                $lyric = pq($doc)->find("p#Lyric")->html();
                $response["lyric"] = $lyric;
            } else {
                $response["errors"] = array("message" => "Not Found.");
            }
        } catch (\Exception $e) {
            $response["errors"] = array("message" => $e->getMessage());
        }
        return $response;
    }
}
