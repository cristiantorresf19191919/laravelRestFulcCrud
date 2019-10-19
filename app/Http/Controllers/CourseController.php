<?php

namespace App\Http\Controllers;

use App\Course;

class CourseController extends Controller {

    public function index(){

        $courses = Course::all();
        return $this->crearRespuestaExitosa($courses, 200);
    }

    public function show($id){
        
        $course = Course::find($id);
        if ($course){

            return $this->crearRespuestaExitosa($course,200);
        }

        return $this->createErrorMessage("El curso con id {$id}, no existe",404);
     
    }




}
