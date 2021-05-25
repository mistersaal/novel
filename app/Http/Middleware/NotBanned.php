<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class NotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guest() && !Auth::user()->is_admin && Auth::user()->is_banned) {

            Auth::logout();
            return response([
                'message' => 'Вы были заблокированы'
            ], 403);
        }

        return $next($request);
    }
}
