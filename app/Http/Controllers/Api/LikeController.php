<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;

class LikeController extends ApiController
{   
    public function create(Request $request)
    {
        $post = Post::find($request->id);
        if(is_null($post)) return response()->json()->setStatusCode(404);

        DB::beginTransaction();
        try {
            Like::insert([
                'post_id' => $post->id,
                'user_id' => auth()->id()
            ]);
            $post->like_count++;
            $post->save();
            Notification::create($post->user->id ,$post->id, 'like');

            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }

    public function destroy(Request $request)
    {
        $post = Post::find($request->id);
        if(is_null($post)) return response()->json()->setStatusCode(404);
        
        DB::beginTransaction();
        try {
            $deleteCount = Like::where('post_id', $post->id)
                ->where('user_id', auth()->id())
                ->delete();
            if($deleteCount != 1) throw new Exception();
            $post->like_count--;
            $post->save();
            Notification::remove($post->user->id ,$post->id);

            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }
}
