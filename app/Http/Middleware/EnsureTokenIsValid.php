<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Traits\MethodResponseTrait;

class EnsureTokenIsValid
{
    use MethodResponseTrait {
        set_error as protected error_response;
        set_success as protected success_response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $request_token = (string)$request->input('token');
        $user = User::select('users.id', 'users.name', 'users.remember_token')
            ->where('users.remember_token', '=', $request_token)
            ->get()
            ->toArray();
        if(count($user) === 0){
            $error = $this->error_response('Error token invalido',__CLASS__, __FUNCTION__, __LINE__);
            return response()->json($error, 500);
        }
        return $next($request);
    }
}
