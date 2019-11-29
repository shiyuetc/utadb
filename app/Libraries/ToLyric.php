<?php

namespace App\Libraries;

class ToLyric
{
    public static function get($artist, $title)
    {
        $response = [];
        try {
            $html = file_get_contents("http://search.j-lyric.net/?ct=2&ca=2&cl=2&ka={$artist}&kt={$title}");
            $doc = \phpQuery::newDocument($html)->find("#mnb");
            $title = pq($doc["div.bdy"])->find("p.mid a")->text();
            $artist = pq($doc["div.bdy"])->find("p.sml a")->text();
            $url = pq($doc["div.bdy"])->find("p.mid a")->attr("href");
            if ($title != "" && $artist != "") {
                $html = file_get_contents($url);
                $doc = \phpQuery::newDocument($html)->find("#mnb");
                $lyric = pq($doc)->find("p#Lyric")->html();
                $response = array(
                    "title" => $title,
                    "artist" => $artist,
                    "lyric" => $lyric
                );
            } else {
                $response["errors"] = array("message" => "Not Found.");
            }
        } catch (Exception $e) {
            $response["errors"] = array("message" => $e->getMessage());
        }
        return $response;
    }
}
