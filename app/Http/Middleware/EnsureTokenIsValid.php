<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     * 
     * @param   \Illuminate\Http\Request  $request
     * @param   \Closure\Illuminate\Http\Request: \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse  $next
     * 
     * @return  \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $request_token = (string)$request->input('token');
        $user = User::select('users.id', 'users.name', 'users.remember_token')
            ->where('users.remember_token', '=', $request_token)
            ->get()
            ->toArray();
        if(sizeof($user) === 0)
            return response()->json(['message' => 'Error token invalido'], 500);
        return $next($request);
    }
}
