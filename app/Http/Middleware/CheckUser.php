<?php

namespace App\Http\Middleware;

use Closure;
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
        if(is_null($user)) {
            abort(404);
        }
        $request->merge(['user' => $user]);
        return $next($request);
    }
}
