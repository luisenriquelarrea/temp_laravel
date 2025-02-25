<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * authenticate user.
     *
     * @return JSON user
     */
    public function authenticate(Request $request)
    {
        return json_encode(['message'=>'hooola mundooooo']);
        if($request->input('username') === NULL && $request->input('password') === NULL){
            $response = [
                'success' => false,
                'message' => 'Error credentials must be set',
            ];
            return response()->json($response, 401);
        }
        $user = User::select('users.id', 'users.name', 'users.email', 'users.grupo_id')
            ->where('users.username', '=', $request->input('username'))
            ->where('users.password', '=', $request->input('password'))
            ->sole()
            ->toArray();
        if(sizeof($user) === 0){
            $response = [
                'success' => false,
                'message' => 'Error no hay informacion en user',
            ];
            return response()->json($response, 401);
        }
        return json_encode($user, 200);
    }
}
