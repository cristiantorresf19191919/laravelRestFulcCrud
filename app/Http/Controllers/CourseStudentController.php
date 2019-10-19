<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CourseStudentController extends Controller {

    public function index($course_id){
            $course = Course::find($course_id);

            if ($course){
                $students = $course->students;
                return $this->crearRespuestaExitosa($students,200);
            }
            return $this->createErrorMessage("no hay curso con este id {$course_id}",404);
    }

    public function store($course_id, $student_id){
        $course = Course::find($course_id);
        if ($course){

            $student = Student::find($student_id);
            if ($student){
                /* $course->students()->find($student_id) */
                /* verifica si hay estudiantes asociados con el curso*/

                if ($course->students()->find($student_id)){

                    return $this->createErrorMessage("ya se encuentra el estudiante con id  {$student_id} registrado en el curso {$course_id}",404);

                }
                $course->students()->attach($student->id);

                return $this->crearRespuestaExitosa("el estudiante con el id {$student_id} ha sido agregado al curso con id {$course_id}",200);

            }
            return $this->createErrorMessage("no hay estudiante con este id {$student_id}",404);


        }
        return $this->createErrorMessage("no hay curso con este id {$course_id}",404);


    }

    public function destroy($course_id,$student_id){
        $course = Course::find($course_id);
        if ($course){
            $student = Student::find($student_id);
            if ($student){
                if(!$course->students()->find($student->id)){
                    return $this->createErrorMessage("el estudiante con el id{$student_id} no pertenece al curso con id {$course->id}",404);
                }
                $course->students()->detach($student->id);
                return $this->crearRespuestaExitosa("el estudiante con el id {$student->id} fue eliminado con exito del curso con id {$course->id}",201);
            }
        }
        return $this->createErrorMessage("el curso con el id{$student_id} no existe en la base de datos",404);


    }



}
