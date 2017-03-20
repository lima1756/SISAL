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
use App\myClasses\Type;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function () {
    return view('welcome');
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

Route::post('/logIn', function () {
    var_dump($_POST);
    if($_POST['stay']=="on")
    {
        if(logData::logIn($_POST['email'], $_POST['pass'], true))
        {
            return redirect('/dashboard');
        }
    }
    else
    {
        if(logData::logIn($_POST['email'], $_POST['pass']))
        {
            return redirect('/dashboard');
        }
    }
});

Route::get('/dashboard', function () {
    if(Type::isMedic())
    {
        return view('doctor/index');
    }
    elseif(Type::isPatient())
    {
        return view('patient/index');
    }
    elseif(Type::isReceptionist())
    {
        return view('receptionist/index');
    }
    elseif(Type::isAdmin())
    {
        return view('admin/index');
    }
    else
    {
        return redirect('/');
    }
});

Route::get('/logOut', function () {
    logData::logOut();
    return redirect('/');
});