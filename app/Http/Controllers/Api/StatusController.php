<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Libraries\SongPuller\Puller;
use App\Models\Post;
use App\Models\Song;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class StatusController extends ApiController
{   
    /**
     * Update state of logined user corresponded to song id.
     * 
     * @param Request $request
     * @return array $response
     */
    public function update(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getSongIdRule(),
            'state' => ApiRequestRules::getStateRule(),
        ]);
        
        $statusArray = ['stacked', 'training', 'mastered'];
        $user = auth()->user();
        $response = [
            'id' => $request->id,
            'old_state' => -1,
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
            $statusId =  $status->id ?? null;
            $nowState = $status->state ?? 0;
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
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Return the state array of logined user corresponded to song id array.
     * 
     * @param Request $request
     * @return array $response
     */
    public function lookup(Request $request)
    {
        $response = [];
        $song_ids = $request->query('ids', []);

        $states = Status::select('song_id', DB::raw('state as my_state'))
            ->where('user_id', auth()->id())
            ->whereIn('song_id', $song_ids)
            ->get();

        $temp_my_state = [];
        foreach($states as $state)
        {
            $temp_my_state[$state->song_id] = $state->my_state;
        }
        foreach($song_ids as $song_id)
        {
            $response[$song_id] = $temp_my_state[$song_id] ?? 0;
        }

        return response()->json($response)->setStatusCode(200);
    }
    
    public function registereUser(Request $request)
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
