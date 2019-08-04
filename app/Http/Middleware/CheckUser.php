<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Status;
use App\Models\User;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('screen_name', $request->id)->first();
        abort_if(is_null($user), 404);
        
        User::setData($user);
        $request->merge(['user' => $user]);
        return $next($request);
    }
}
