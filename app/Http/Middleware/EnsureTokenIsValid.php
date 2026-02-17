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
    public function handle(Request $request, Closure $next)
    {
        $request_token = $request->bearerToken();

        if (!$request_token)
            return response()->json(['message' => 'Token requerido'], 401);

        $user = User::where('remember_token', $request_token)->first();

        if (!$user)
            return response()->json(['message' => 'Token invalido'], 401);

        return $next($request);
    }
}
