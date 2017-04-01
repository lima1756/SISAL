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

Route::get('/ajaxDP', function() {
    if(Type::isMedic())
    {
        //Query basico c:
        $generales = dbConnection::select(["pacientes.*"], 
            "pacientes", 
            [["pacientes.id_usuario", /*$_POST['patientId']*/ 1009]]);
        var_dump($generales);
        if($generales[0]['id_antecedentes'] != null)
        {
            $antecedentes = dbConnection::select(["antecedentes.*"], "antecedentes", [["antecedentes.id_antecedentes", $generales[0]['id_antecedentes']]]);
            var_dump($antecedentes);
        }
        if($generales[0]['id_interrogatorio'] != null)
        {
            $interrogatorio = dbConnection::select(["interrogatorio.*"], "interrogatorio", [["interrogatorio.id_interrogatorio", $generales[0]['id_interrogatorio']]]);
            var_dump($interrogatorio);
        }
        if($generales[0]['id_alergias'] != null)
        {
            $alergias = dbConnection::select(["alergias.*"], "alergias", [["alergias.id_alergias", $generales[0]['id_alergias']]]);
            var_dump($alergias);
        }
        if($generales[0]['id_estiloVida'] != null)
        {
            $estiloVida = dbConnection::select(["estiloVida.*"], "estiloVida", [["estiloVida.id_estiloVida", $generales[0]['id_estiloVida']]]);
            var_dump($estiloVida);
            if($estiloVida[0]["id_ejercicio"])
            {
                $ejercicio = dbConnection::select(["ejercicio.*"], "ejercicio", [["ejercicio.id_ejercicio", $estiloVida[0]['id_ejercicio']]]);
                var_dump($ejercicio);
            }
            if($estiloVida[0]["id_suenio"])
            {
                $suenio = dbConnection::select(["suenio.*"], "suenio", [["suenio.id_suenio", $estiloVida[0]['id_suenio']]]);
                var_dump($suenio);
            }
            if($estiloVida[0]["id_comidas"])
            {
                $comidas = dbConnection::select(["comidas.*"], "comidas", [["comidas.id_comidas", $estiloVida[0]['id_comidas']]]);
                var_dump($comidas);
            }
            if($estiloVida[0]["id_refresco"])
            {
                $refresco = dbConnection::select(["refresco.*"], "refresco", [["refresco.id_refresco", $estiloVida[0]['id_refresco']]]);
                var_dump($refresco);
            }
            if($estiloVida[0]["id_dietas"])
            {
                $dietas = dbConnection::select(["dietas.*"], "dietas", [["dietas.id_dietas", $estiloVida[0]['id_dietas']]]);
                var_dump($dietas);
            }
        }
        
        /**$datos = dbConnection::select(["antecedentes.*", "interrogatorio.*", "alergias.*", "usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios. codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar", "tipo_sangre.tipo", "refresco.vasosDiarios", "suenio.horasDiarias", "intravenosa.descripcion", 
                "fumador.edad_inicio", "fumador.ciggarrosDiarios", "ex_fumador.edad_fin", "ex_alcoholico.edad_fin", "ex_adicto.edad_fin", "ejercicio.veces_semana", "drogas.detalles",
                "drogas.edad_inicio", "drogas.detalles", "dietas.informacionDieta", "comidas.desayuno", "comidas.comidasDiarias", "alcoholico.edad_inicio", "alcoholico.vasos"
            ], 
            "usuarios",
            [["usuarios.id_usuario", $_POST['patientId']]],
            [["pacientes", "usuarios.id_usuario", "pacientes.id_usuario"], ["antecedentes", "antecedentes.id_antecedentes", "pacientes.id_antecedentes"], 
                ["interrogatorio", "interrogatorio.id_interrogatorio", "pacientes.id_interrogatorio"], ["alergias", "alergias.id_alergias", "pacientes.id_alergias"],
                ["estiloVida", "estilovida.id_estiloVida", "pacientes.id_estiloVida"], ["ejercicio", "estilovida.id_ejercicio", "ejercicio.id_ejercicio"], 
                ["suenio", "estilovida.id_suenio", "suenio.id_suenio"], ["comidas", "estilovida.id_comidas", "comidas.id_comidas"],
                ["refresco", "estilovida.id_refresco", "refresco.id_refresco"], ["drogas", "estilovida.id_drogas", "drogas.id_drogas"],
                ["alcoholico", "estilovida.id_alcoholismo", "alcoholico.id_alcoholico"], ["ex_alcoholico", "estilovida.id_exAlcoholismo", "ex_alcoholico.id_exAlcoholico"],
                ["ex_adicto", "estilovida.id_exAdicto", "ex_adicto.id_exAdicto"], ["fumador", "estilovida.id_fumador", "fumador.id_fumador"],
                ["ex_fumador", "estilovida.id_exFumador", "ex_fumador.id_exFumador"], ["intravenosa", "drogas.id_intravenosa", "intravenosa.id_intravenosa"],
                ["tipo_sangre", "tipo_sangre.id_sangre", "antecedentes.id_sangre"], ["dietas", "estilovida.id_dietas", "dietas.id_dietas"]]
            );
        var_dump($datos);*/
    }
    else
    {
        return 0;
    }
});