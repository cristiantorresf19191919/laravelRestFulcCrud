<?php

namespace App\Http\Controllers;

use App\Course;
use App\Teacher;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherCourseController extends Controller {

    public function index($teacher_id){

        $teacher = Teacher::find($teacher_id);
        if ($teacher){
            $courses = $teacher->courses;
            return $this->crearRespuestaExitosa($courses,200);
        }
        return $this->createErrorMessage("no hay teacher con este id {$teacher_id}",404);
    }

    public function store(Request $request, $teacher_id){
        $teacher = Teacher::find($teacher_id);
        if ($teacher){
            $reglas = [
                'title' => 'required',
                'description' => 'required',
                'value' => 'required | numeric'
            ];
            $this->validate($request,$reglas);
            $asociativoArreglo = [
                "title" => $request['title'],
                "description" => $request['description'],
                "value" => $request['value'],
                "teacher_id" =>$teacher->id
            ];
            $course =  Course::create($asociativoArreglo);
            $course->save();
            return $this->crearRespuestaExitosa("se ha creado el curso {$course->title} con id {$course->id} para el profesor con id {$teacher->id}",201);
        }
        return $this->createErrorMessage("no hay teacher con este id {$teacher_id}",404);
    }



    public function update(Request $request ,$teacher_id, $course_id){

        $teacher = Teacher::find($teacher_id);


        if ($teacher){
            $course = Course::find($course_id);
            if ($course){
                $course->title = $request->get('title');
                $course->description = $request->get('description');
                $course->value = $request->get('value');
                $course->teacher_id = $teacher_id;
                $course->save();
                return $this->crearRespuestaExitosa("se ha creado el curso {$course->title} con id {$course->id} para el profesor con id {$teacher_id}",201);
            }
            return $this->createErrorMessage("no hay curso con este id {$course_id}",404);
        }
        return $this->createErrorMessage("no hay teacher con este id {$teacher_id}",404);


    }

    public function destroy($teacher_id, $course_id){
        $teacher = Teacher::find($teacher_id);
        if ($teacher){
            $course = Course::find($course_id);
            if ($course){
                // verifica que el curso pertenzca al profesor 
                if ($teacher->courses()->find($course_id)){
                    // solo desvincula los estudiantes para que no vote error
                    $course->students()->detach();
                    // ya desvinculado ahora si borra el curso con el id dado
                    $course->delete();
                    return $this->crearRespuestaExitosa(" los estudiantes {$course->students} se han desvinculado con el curso con id {$course_id}",201);
                }
                return $this->createErrorMessage("el curso {$course_id} no esta asociado con el profesor con id {$teacher_id}",404);
            }
            return $this->createErrorMessage("el curso {$course_id} no existe",404);



        }

    }



}
