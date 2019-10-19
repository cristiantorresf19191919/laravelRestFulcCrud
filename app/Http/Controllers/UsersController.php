<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    function index(Request $request){

        if ($request -> isJson()){
            $usuario = User::all();
            // $usuario->password
            return response()->json([$usuario], 201);
        }
        return response()->json(['error' => 'Desautorizado'],  401);
    }

    function createUser(Request $request){

        function generarRandom($cantidad){
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle(str_repeat($pool, 5)), 0, $cantidad);
        }
        if ($request->isJson()){
            // TODO:create the user in the Db
            $data = $request->json()->all();
            $arreglo = [
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make( $data['password']),
                'api_token' => generarRandom(60)
            ];
            $usuario = User::create($arreglo);

        }
    }

    function getToken(Request $request){
        // header content-type application-json
        if ($request->isJson()){
            try{
                $datos = $request->json()->all();
                $user = User::where('username', $datos['username'])->first();
                if ($user && Hash::check($datos['password'], $user->password)){
                    return response()->json($user, 200);
                } else{
                    return response()->json(['error'=>'No hay contenido'],406);
                }
            }
            catch(ModelNotFoundException $e){
                return response()->json(['error catch'=>'No hay contenido'],406);
            }
        }

    }

}

