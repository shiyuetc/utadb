<?php

namespace App\Http\Controllers\Api;

use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class FriendController extends ApiController
{   
    /**
     * Return following user array.
     * 
     * @param Request $request
     * @return array $response
     */
    public function following(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
            'page' => 'nullable|numeric|between:1,9999',
        ]);

        $response = [];
        $page = $request->query('page', 1);

        $results = Friend::select('user_id')
            ->where('following_id', $request->id)
            ->skip(($page - 1) * 20)
            ->take(20)
            ->with('user')
            ->get();

        foreach($results as $result) {
            $response[] = $result->user;
        }

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Return follower user array.
     * 
     * @param Request $request
     * @return array $response
     */
    public function followers(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
            'page' => 'nullable|numeric|between:1,9999',
        ]);

        $response = [];
        $page = $request->query('page', 1);

        $results = Friend::select('following_id')
            ->where('user_id', $request->id)
            ->skip(($page - 1) * 20)
            ->take(20)
            ->with('following')
            ->get();

        foreach($results as $result) {
            $response[] = $result->following;
        }

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Create follow a user.
     * 
     * @param Request $request
     * @return bool
     */
    public function create(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
        ]);

        $following_user = auth()->user();
        if($following_user->id == $request->id) return response()->json()->setStatusCode(422);

        $user = User::find($request->id);
        if(is_null($user)) return response()->json()->setStatusCode(404);

        DB::beginTransaction();
        try {
            Friend::insert([
                'user_id' => $user->id,
                'following_id' => auth()->id()
            ]);
            $following_user->following_count++;
            $user->follower_count++;
            $following_user->save();
            $user->save();
            Notification::create($user->id, null, 'follow');

            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }

    /**
     * Create unfollow a user.
     * 
     * @param Request $request
     * @return bool
     */
    public function destroy(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => 'required|numeric',
        ]);
        
        $following_user = auth()->user();
        if($following_user->id == $request->id) return response()->json()->setStatusCode(422);
        
        $user = User::find($request->id);
        if(is_null($user)) return response()->json()->setStatusCode(404);
        
        DB::beginTransaction();
        try {
            $deleteCount = Friend::where('user_id', $user->id)
                ->where('following_id', auth()->id())
                ->delete();
            if($deleteCount != 1) throw new \Exception();
            $following_user->following_count--;
            $user->follower_count--;
            $following_user->save();
            $user->save();
            Notification::remove($user->id);

            DB::commit();
            return response()->json()->setStatusCode(200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json()->setStatusCode(400);
        }
    }

}
