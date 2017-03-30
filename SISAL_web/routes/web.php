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
use App\myClasses\dbConnection;
use App\myClasses\logData;
use App\myClasses\Type;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function () {
    return view('welcome');
});

Route::get('/registerPersonal', function () {
  return view('admin/registerPersonal');
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

Route::post('/newNote', function () {
   dbConnection::insert("notas", ["contenido", "id_usuario"], [[$_POST['note'], logData::getData("id_usuario")]]);
    return redirect('/dashboard');
});

Route::get('/dashboard/dates', function () {
    if(Type::isMedic())
    {
        return view('doctor/dates');
    }
    elseif(Type::isPatient())
    {
        return view('patient/dates');
    }
    elseif(Type::isReceptionist())
    {
        return view('receptionist/dates');
    }
    else
    {
        return redirect('/dashboard');
    }
});

Route::get('/dashboard/registerData', function () {
    if(Type::isMedic())
    {
        return view('doctor/registerData');
    }
    else
    {
        return redirect('/dashboard');
    }
});

Route::post('/registerDate', function () {
    //Interrogatorio
    dbConnection::insert("registro_interrogatorio", ["motivoConsulta", "sintomas"], [[$_POST['motivo'], $_POST['sintomas']]]);
    $idInterrogatorio = dbConnection::lastID();
    //exploración
    dbConnection::insert("exploracion", ["peso", "talla", "frecuenciaRespiratoria", "presArterAlta", "presArterBaja", "temperatura", "frecuenciaCardiaca", "exploracionFisica"], 
        [[$_POST['peso'], $_POST['talla'], $_POST['frecResp'], $_POST['presAlta'], $_POST['presBaja'], $_POST['temp'], $_POST['frecCard'], $_POST['exploracion']]]);
    $idExploracion = dbConnection::lastID();
    //Diagnostico
    dbConnection::insert("diagnostico", ["enfermedad", "estado", "notas"], 
        [[$_POST['enfermedad'], $_POST['estadoEnfermedad'], $_POST['notasEnfermedad']]]);
    $idDiagnostico = dbConnection::lastID();
    //notas Adicionales
    dbConnection::insert("notas_adicionales", ["notas"], 
        [[$_POST['notasAdicionales']]]);
    $idNotasAdd = dbConnection::lastID();
    //Estudios
    dbConnection::insert("estudios", ["orden"], 
        [[$_POST['estudios']]]);
    $idEstudios = dbConnection::lastID();
    //registro clinico
    dbConnection::insert("registro_clinico", ["id_medico", "id_paciente", "id_diagnostico", "id_interrogatorio", "id_exploracion", "id_notasAdicionales", "id_estudios"], 
        [[logData::getData("id_usuario"), $_POST['idPatient'], $idDiagnostico, $idInterrogatorio, $idExploracion, $idNotasAdd, $idEstudios]]);
    $idRegistro = dbConnection::lastID();
    
    

    for($x = 0; $x < $_POST['cantidad']; $x++)
    {
        if($_POST['medID'][$x]!=0)
        {
            dbConnection::insert("tratamiento", ["id_medicamento", "cada", "inicio", "indicaciones", "id_registro"], 
                [[$_POST['medID'][$x], $_POST['medCada'][$x], $_POST['medStart'][$x], $_POST['medIndi'][$x], $idRegistro]]);
        }
        else
        {
            dbConnection::insert("medicamentos", ["nombre"], 
                [[$_POST['medName'][$x]]]);
            $idMed = dbConnection::lastID();
            dbConnection::insert("tratamiento", ["id_medicamento", "cada", "inicio", "indicaciones", "id_registro"], 
                [[$idMed, $_POST['medCada'][$x], $_POST['medStart'][$x], $_POST['medIndi'][$x], $idRegistro]]);
        }
    }
    return redirect('/dashboard/patients');
});

Route::get('/dashboard/patients', function() {
    if(Type::isMedic())
    {
        return view('doctor/patients');
    }
    else
    {
        return redirect('/dashboard');
    }
});

Route::post('/ajaxDP', function() {
    if(Type::isMedic())
    {
        
    }
    else
    {
        return 0;
    }
});