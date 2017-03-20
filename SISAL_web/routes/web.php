<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\myClasses\logData;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {

        return view('receptionist/index');
});

Route::get('/doctor', function () {
    return view('doctor/index');
});

Route::get('/admin', function () {
    return view('admin/index');
});
Route::get('/patient', function () {
    return view('patient/index');
});

Route::get('/receptionist', function () {
  return view('receptionist/index');
});
