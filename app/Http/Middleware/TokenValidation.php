<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\users;

class TokenValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $dbtoken = users::where('id', $request->input('User_id'))
        ->select('api_token')
        ->first();
        if ($request->input('token') !== $dbtoken->api_token) {
            return abort(403);
        } else { 
            $response = $next($request);
            return $response;
        }
    }
}
