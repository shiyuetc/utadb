<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Activity;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;

class LikeController extends ApiController
{   
    public function create(Request $request)
    {
        $activity = Activity::find($request->id);
        if(is_null($activity)) return response()->json()->setStatusCode(404);

        DB::beginTransaction();
        try {
            Like::insert([
                'activity_id' => $activity->id,
                'user_id' => auth()->id()
            ]);
            $activity->like_count++;
            $activity->save();
            Notification::create($activity->user->id ,$activity->id, 'like');

            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }

    public function destroy(Request $request)
    {
        $activity = Activity::find($request->activity_id);
        if(is_null($activity)) return response()->json()->setStatusCode(404);
        
        DB::beginTransaction();
        try {
            $deleteCount = Like::where('activity_id', $activity->id)
                ->where('user_id', auth()->id())
                ->delete();
            if($deleteCount != 1) throw new Exception();
            $activity->like_count -= 1;
            $activity->save();
            Notification::remove($activity->user->id ,$activity->id);

            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }
}
