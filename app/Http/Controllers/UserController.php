<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Traits\MethodResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use MethodResponseTrait {
        set_error as protected error_response;
        set_success as protected success_response;
    }

    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new User;
        $tabla = 'users';
        parent::__construct($modelo, $tabla);
    }

    public function index()
    {
        return User::select('users.*')->orderBy('id', 'ASC')->get();
    }

    /**
     * authenticate user.
     *
     * @return JSON user
     */
    public function authenticate(Request $request)
    {
        return json_encode(['mesaage'=>'hooola mundooooo']);
        if($request->input('username') === NULL && $request->input('password') === NULL){
            $response = [
                'success' => false,
                'message' => 'Error credentials must be set',
            ];
            return response()->json($response);
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
            return response()->json($response);
        }
        /*if((string)$user['grupo_id'] === ''){
            $response = [
                'success' => false,
                'message' => 'Error user no tiene un grupo ACL asignado',
            ];
            return response()->json($response);
        }*/
        return json_encode($user);
    }

    /**
     * Display authentication error response.
     *
     * @return JSON response
     */
    public function auth_error()
    {
        $error = $this->error_response("Error al autenticar", __CLASS__, __FUNCTION__, __LINE__);
        return response()->json($error, 500);
    }
}
