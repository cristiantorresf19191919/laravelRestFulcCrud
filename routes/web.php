<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->post('/users/login',['uses' => 'usersController@getToken']);
$router->post('/users',['uses' => 'usersController@createuser']);


/* $router->get('/users',['uses' => 'usersController@index']); */
$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('/users',['uses' => 'usersController@index']);
});


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function (){
    return "hola";
});

$router->get('/teacher','TeacherController@index');
$router->post('/teacher','TeacherController@store');
$router->get('/teacher/{teachers}','TeacherController@show');
$router->put('/teacher/{teachers}','TeacherController@update');
$router->patch('/teacher/{teachers}','TeacherController@update');
$router->delete('/teacher/{teachers}','TeacherController@destroy');

$router->get('/student','StudentController@index');
$router->post('/student','StudentController@store');
$router->get('/student/{student}','StudentController@show');
$router->put('/student/{student}','StudentController@update');
$router->patch('/student/{student}','StudentController@update');
$router->delete('/student/{student}','StudentController@destroy');

$router->get('/course','CourseController@index');
$router->get('/course/{course}','CourseController@show');
$router->post('/course','CourseController@store');


$router->get('/teacher/{teacher}/course','TeacherCourseController@index');
$router->post('/teacher/{teacher}/course','TeacherCourseController@store');
$router->put('/teacher/{teacher}/course/{course}','TeacherCourseController@update');
$router->patch('/teacher/{teacher}/course/{course}','TeacherCourseController@update');
$router->delete('/teacher/{teacher}/course/{course}','TeacherCourseController@destroy');

$router->get('/course/{course}/student','CourseStudentController@index');
$router->post('/course/{course}/student/{student}','CourseStudentController@store');
$router->delete('/course/{course}/student/{student}','CourseStudentController@destroy');








