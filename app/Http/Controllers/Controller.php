<?php

/* Controlador Base */

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function crearRespuestaExitosa($data, $code)
    {
        return response()->json($data=['data'=>$data], $code);
    }

    public function createErrorMessage($mensaje, $codigo){

        return response()->json(["mensaje" => $mensaje, "codigo"=> $codigo] ,$codigo);
    }

    public function validarRequestStudent($request){

        $reglas = [
            'name' => 'required|unique:students,name',
            'phone' => 'required|numeric',
            'address' => 'required',
            'career' => 'required|in:ingeniero,matematico,fisico',
        ];
        $this->validate($request, $reglas);

    }

    public function validarRequestTeacher($request){

        $reglas = [
            'name' => 'required|unique:students,name',
            'phone' => 'required|numeric',
            'address' => 'required',
            'profession' => 'required|in:ingeniero,matematico,fisico',
        ];
        $this->validate($request, $reglas);

    }


}
