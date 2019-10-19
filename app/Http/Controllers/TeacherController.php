<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller {

    public function index(){

        $teachers = Teacher::all();
        return $this->crearRespuestaExitosa($teachers, 200);

    }

    public function show($id){
        $teacher = Teacher::find($id);
        if ($teacher){
            return $this->crearRespuestaExitosa($teacher,200);
        }
        return $this->createErrorMessage("El curso con id {$id}, no existe",404);
    }

    public function store(Request $request){
        // post
        $reglas = [
            'name' => 'required|unique:teachers,name',
            'phone' => 'required|numeric',
            'address' => 'required',
            'profession' => 'required|in:ingeniero,matematico,fisico',
        ];
        $this->validate($request, $reglas);
        $teacher = Teacher::create($request->all());
        return $this->crearRespuestaExitosa($teacher,201);
    }



    public function update(Request $request, $teacher_id){
        $teacher= Teacher::find($teacher_id);
        if ($teacher){
            /* si las entradas estan mal rompe la funcion y muestra mensaje */
            $this->validarRequestTeacher($request);
            /* $this->validarRequest($request); */
            $teacher->name = $request->get('name');
            $teacher->phone = $request->get('phone');
            $teacher->address = $request->get('address');
            $teacher->profession = $request->get('profession');
            $teacher->save();
            return $this->crearRespuestaExitosa("se ha actualizado el estudiante con {$teacher->id}",201);
        }
        return $this->createErrorMessage('el id del estudiante no existe',404);
    }

    public function destroy($teacher_id){
        $teacher = Teacher::find($teacher_id);
        if ($teacher){

           $courses = $teacher->courses;
        //    mirar si el profesor tiene cursos
           if (sizeof($courses) > 0){
                return $this->createErrorMessage('no puedes borrar el profesor {$teacher->name} porque tiene cursos activos primero borra los cursos',409);
           }

           $teacher->delete();
           return $this->crearRespuestaExitosa("el profesor {$teacher->name} se ha eliminado con exito", 201);
        }
        return $this->createErrorMessage('el id del profesor no existe',404);
    }

}
