<?php

namespace App\Http\Controllers;

use App\Student;
use App\Teacher;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller {

    public function index(){

        $students = Student::all();
        return $this->crearRespuestaExitosa($students, 200);

    }


    public function show($id){

        $student = Student::find($id);
        if ($student){
            return $this->crearRespuestaExitosa($student,200);
        }
        return $this->createErrorMessage("El curso con id {$id}, no existe",404);
    }

    public function store(Request $request){
        $this->validarRequest($request);
        $teacher = Student::create($request->all());
        return $this->crearRespuestaExitosa($teacher,201);
    }

    public function update(Request $request, $student_id){

        $student= Student::find($student_id);
        if ($student){
            /* si las entradas estan mal rompe la funcion y muestra mensaje */
            $this->validarRequestStudent($request);
            $student->name = $request->get('name');
            $student->phone = $request->get('phone');
            $student->address = $request->get('address');
            $student->career = $request->get('career');
            $student->save();
            return $this->crearRespuestaExitosa('se ha actualizado el estudiante con {$student->id}',201);
        }
        return $this->createErrorMessage('el id del estudiante no existe',404);

    }

    public function destroy($student_id){

        $student = Student::find($student_id);
        if ($student){
            $student->courses()->detach();
            $student->delete();
            return $this->crearRespuestaExitosa("se ha borrado el estudiante con id {$student_id}",201);

        }
        return $this->createErrorMessage('el id del estudiante no existe',404);


    }





}
