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

Route::get('/registerPersonal', function () {
  return view('admin/registerPersonal');
});

Route::get('/registerData', function () {
  return view('doctor/registerData');
});

Route::get('/patients', function () {
  return view('doctor/patients');
});
Route::get('/dates', function () {
  return view('doctor/dates');
});
Route::get('/userProfile', function () {
  return view('doctor/userProfile');
});
Route::get('/Personal', function () {
  return view('admin/Personal');
});




Route::post('/logIn', function () {
    if(isset($_POST['stay']))
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
    return redirect('/?error=signin');
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