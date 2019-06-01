<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StatusRequest;
use App\Models\Status;
use App\Models\Song;
use App\Libraries\SongPuller\Puller;
use DB;
use Exception;

class ApiController extends Controller
{   
    public function updateStatus(StatusRequest $request)
    {
        //$user_id = Auth::id();
        $user_id = 1;
        DB::beginTransaction();
        try {
            // 現在のステータスを取得
            $state = Status::select('state')
                ->where('user_id', $user_id)
                ->where('song_id', $request->id)
                ->first();
            $state = isset($state) ? $state->state : 0;
            if($state == $request->state) {
                throw new Exception('変更前と変更後のステータスが同じです');
            }

            if($state === 0) { // ステータスの追加
                if(!Song::where('id', $request->id)->exists()) {
                    $puller = new Puller();
                    $song = $puller->lookSong($request->id);
                    if(is_null($song)) {
                        throw new Exception('曲情報の取得に失敗しました');
                    }

                    $result = Song::insert([
                        'id' => $song['id'],
                        'title' => $song['title'],
                        'artist_id' => $song['artist_id'],
                        'artist' => $song['artist'],
                        'image_url' => $song['image_url'],
                        'audio_url' => $song['audio_url']
                    ]);
                    if(!$result) {
                        throw new Exception('曲情報の取得に失敗しました');
                    }
                }
            } elseif($request->state !== 0) { // ステータスの更新

            } else { // ステータスの削除

            }

            DB::commit();
            return response()->json($state);
        } catch (Exception $e){
            DB::rollBack();
            throw new HttpResponseException(response()->json(['errors' => $e->getMessage()], 422));
        }
    }

    public function publicTimeline()
    {
        $statuses = Status::publicTimeline();
        return response()->json($statuses);
    }
}
