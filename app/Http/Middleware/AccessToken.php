<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class AccessToken
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
        $user = User::find($request->input('user_id'));

        if (is_null($user) || $user->access_token != $request->bearerToken()) {
            abort(401, 'Unauthorized');
        }

        return $next($request);
    }
}
