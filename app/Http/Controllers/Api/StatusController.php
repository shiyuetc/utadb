<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Post;
use App\Models\Song;
use App\Models\Status;
use App\Libraries\SongPuller\Puller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class StatusController extends ApiController
{   
    public function edit(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getSongIdRule(),
            'state' => ApiRequestRules::getStateRule(),
        ]);
        
        $statusArray = ['stacked', 'training', 'mastered'];
        $user = auth()->user();
        $response = [];
        $response = [
            'id' => $request->id,
            'old_state' => '-1',
            'new_state' => $request->state,
            'user' => $user
        ];

        DB::beginTransaction();
        try {
            // 現在のステータスを取得
            $status = Status::select('id', 'state')
                ->where('user_id', $user->id)
                ->where('song_id', $request->id)
                ->first();
            if(isset($status)) {
                $statusId =  $status->id;
                $nowState = $status->state;
            } else {
                $statusId = null;
                $nowState = 0;
            }
            $response['old_state'] = $nowState;
            if($nowState == $request->state) {
                return response()->json($response)->setStatusCode(200);
            }

            if($nowState == 0) { 
                // 曲がローカルに存在しない場合は追加
                if(!Song::where('id', $request->id)->exists()) {
                    $song = Puller::lookSong($request->id);
                    $result = Song::insert([
                        'id' => $song['id'],
                        'title' => $song['title'],
                        'artist_id' => $song['artist_id'],
                        'artist' => $song['artist'],
                        'image_url' => $song['image_url'],
                        'audio_url' => $song['audio_url']
                    ]);
                }
                // ステータスの追加
                Status::insert([
                    'user_id' => $user->id,
                    'song_id' => $request->id,
                    'state' => $request->state
                ]);
                $user[$statusArray[$request->state - 1] . '_count'] += 1;
            } elseif($request->state != 0) { 
                // ステータスの更新
                Status::find($statusId)->update([
                    'state' => $request->state,
                    'used_at' => Carbon::now()
                ]);
                $user["{$statusArray[$request->state - 1]}_count"] += 1;
                $user["{$statusArray[$nowState - 1]}_count"] -= 1;
            } else {  
                // ステータスの削除
                Status::find($statusId)->delete();
                $user["{$statusArray[$nowState - 1]}_count"] -= 1;
            }
            
            Post::insert([
                'id' => str_pad(str_replace('.', '', microtime(true)), 14, '0', STR_PAD_RIGHT),
                'user_id' => $user->id,
                'song_id' => $request->id,
                'old_state' => $nowState,
                'state' => $request->state
            ]);
            $user->record_count++;
            $user->save();
            DB::commit();
            $response['user']->record_count++;
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
        return response()->json($response)->setStatusCode(200);
    }
    
    public function lookup(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getSongIdRule(),
        ]);
        
        $response = [1 => [], 2 => [], 3 => []];
        $rows = Status::select('user_id', 'state')
            ->where('song_id', $request->id)
            ->orderBy('used_at', 'desc')
            ->with('user')
            ->get();
        foreach($rows as $row) {
            $response[(int)$row['state']][] = $row['user'];
        }
        return response()->json($response)->setStatusCode(200);
    }
}
