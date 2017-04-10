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
Route::get('/dashboard/userProfile', function () {
   
        return view('doctor/userProfile');
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

//Receta PDF
Route::get('/receta', function() {
    return view('disenio');
});

Route::get('/prueba', function() {
   try {
    ob_start();
    include '\disenio.php';
    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('L', 'A4', 'fr');
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('Receta.pdf');//D si se desea descargar
    } catch (Html2PdfException $e) {
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getHtmlMessage();
    }
});



//FIN Receta PDF


Route::POST('/ajaxDP', function() {
    if(Type::isMedic())
    {
        $infoPacientes = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios. codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar", "pacientes.*"], 
            "pacientes", 
            [["pacientes.id_usuario", $_POST['patientId']]],
            [["usuarios", "pacientes.id_usuario", "usuarios.id_usuario"]]);
        $infoPacientes['generales'] = $generales[0];
        if($generales[0]['id_antecedentes'] != null)
        {
            $antecedentes = dbConnection::select(["antecedentes.*"], "antecedentes", [["antecedentes.id_antecedentes", $generales[0]['id_antecedentes']]]);
            $infoPacientes['antecedentes'] = $antecedentes[0];
            if($antecedentes[0]['id_sangre'] != null)
            {
                $sangre = dbConnection::select(["tipo_sangre.tipo"], "tipo_sangre", [["tipo_sangre.id_sangre", $antecedentes[0]['id_sangre']]]);
                $infoPacientes['sangre'] = $sangre[0];
            }
        }
        if($generales[0]['id_interrogatorio'] != null)
        {
            $interrogatorio = dbConnection::select(["interrogatorio.*"], "interrogatorio", [["interrogatorio.id_interrogatorio", $generales[0]['id_interrogatorio']]]);
            $infoPacientes['interrogatorio'] = $interrogatorio[0];
        }
        if($generales[0]['id_alergias'] != null)
        {
            $alergias = dbConnection::select(["alergias.*"], "alergias", [["alergias.id_alergias", $generales[0]['id_alergias']]]);
            $infoPacientes['alergias'] = $alergias[0];
        }
        if($generales[0]['id_estiloVida'] != null)
        {
            $estiloVida = dbConnection::select(["estiloVida.*"], "estiloVida", [["estiloVida.id_estiloVida", $generales[0]['id_estiloVida']]]);
            $infoPacientes['estiloVida'] = $estiloVida[0];
            if($estiloVida[0]["id_ejercicio"] != null)
            {
                $ejercicio = dbConnection::select(["ejercicio.veces_semana"], "ejercicio", [["ejercicio.id_ejercicio", $estiloVida[0]['id_ejercicio']]]);
                $infoPacientes['ejercicio'] = $ejercicio[0];
            }
            if($estiloVida[0]["id_suenio"] != null)
            {
                $suenio = dbConnection::select(["suenio.horasDiarias"], "suenio", [["suenio.id_suenio", $estiloVida[0]['id_suenio']]]);
                $infoPacientes['suenio'] = $suenio[0];
            }
            if($estiloVida[0]["id_comidas"] != null)
            {
                $comidas = dbConnection::select(["comidas.desayuno", "comidas.comidasDiarias"], "comidas", [["comidas.id_comidas", $estiloVida[0]['id_comidas']]]);
                $infoPacientes['comidas'] = $comidas[0];
            }
            if($estiloVida[0]["id_refresco"] != null)
            {
                $refresco = dbConnection::select(["refresco.vasosDiarios"], "refresco", [["refresco.id_refresco", $estiloVida[0]['id_refresco']]]);
                $infoPacientes['refresco'] = $refresco[0];
            }
            if($estiloVida[0]["id_dietas"] != null)
            {
                $dietas = dbConnection::select(["dietas.informacionDieta"], "dietas", [["dietas.id_dietas", $estiloVida[0]['id_dietas']]]);
                $infoPacientes['dietas'] = $dietas[0];
            }
            if($estiloVida[0]["id_alcoholismo"] != null)
            {
                $alcoholico = dbConnection::select(["alcoholico.edad_inicio", "alcoholico.vasos"], "alcoholico", [["alcoholico.id_alcoholico", $estiloVida[0]['id_alcoholismo']]]);
                $infoPacientes['alcoholico'] = $alcoholico[0];
            }
            if($estiloVida[0]["id_exAlcoholismo"] != null)
            {
                $ex_alcoholico = dbConnection::select(["ex_alcoholico.edad_fin"], "ex_alcoholico", [["ex_alcoholico.id_exAlcoholico", $estiloVida[0]['id_exAlcoholismo']]]);
                $infoPacientes['ex_alcoholico'] = $ex_alcoholico[0];
            }
            if($estiloVida[0]["id_drogas"]!= null)
            {
                $drogas = dbConnection::select(["drogas.edad_inicio", "drogas.detalles", "drogas.intravenosa"], "drogas", [["drogas.id_drogas", $estiloVida[0]['id_drogas']]]);
                $infoPacientes['drogas'] = $drogas[0];
            }
            if($estiloVida[0]["id_exAdicto"] != null)
            {
                $ex_adicto = dbConnection::select(["ex_adicto.edad_fin"], "ex_adicto", [["ex_adicto.id_exAdicto", $estiloVida[0]['id_exAdicto']]]);
                $infoPacientes['exAdicto'] = $ex_adicto[0];
            }
            if($estiloVida[0]["id_fumador"] != null)
            {
                $fumador = dbConnection::select(["fumador.edad_inicio", "fumador.ciggarrosDiarios"], "fumador", [["fumador.id_fumador", $estiloVida[0]['id_fumador']]]);
                $infoPacientes['fumador'] = $fumador[0];
            }
            if($estiloVida[0]["id_exFumador"] != null)
            {
                $ex_fumador = dbConnection::select(["ex_fumador.edad_fin"], "ex_fumador", [["ex_fumador.id_exFumador", $estiloVida[0]['id_exFumador']]]);
                $infoPacientes['ex_fumador'] = $ex_fumador[0];
            }
            if($estiloVida[0]["id_cafe"] != null)
            {
                $cafe = dbConnection::select(["cafe.tazasDiarias"], "cafe", [["cafe.id_cafe", $estiloVida[0]['id_cafe']]]);
                $infoPacientes['cafe'] = $cafe[0];
            }
            return json_encode($infoPacientes);

        }
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxDDdP'/* Doctor obtiene doctores de paciente */, function()  {
    if(Type::isMedic())
    {
        $listaDoctores = dbConnection::select(
            ['registro_clinico.id_medico', 'usuarios.nombre', 'usuarios.apellidoPaterno', 'usuarios.apellidoMaterno', 'usuarios.usuario'],
            "registro_clinico",
            [['registro_clinico.id_paciente', $_POST['patientId']]],
            [['usuarios', 'registro_clinico.id_medico', 'usuarios.id_usuario']],
            "GROUP BY registro_clinico.id_medico");
        $listaDoctores['cantidad'] = count($listaDoctores);
        return json_encode($listaDoctores);
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxDCdDdP' /* Doctor obitiene Citas de Doctores de Paciente */, function() {
    if(Type::isMedic())
    {
        $listaCitas = dbConnection::select(
            ['registro_clinico.id_registro', 'DATE_FORMAT(registro_clinico.fecha_hora, \'%d/%m/%y\') AS fecha'],
            "registro_clinico",
            [['registro_clinico.id_paciente', $_POST['patientId']], 
                ['registro_clinico.id_medico', $_POST['doctorId']]],
            [],
            "ORDER BY fecha DESC"
            );
        $listaCitas['cantidad'] = count($listaCitas);
        return json_encode($listaCitas);
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxDCdP' /* Doctor obtiene Cita de paciente*/, function() {
    if(Type::isMedic())
    {
        $cita = dbConnection::select(
            ['registro_clinico.id_diagnostico', 'registro_clinico.id_interrogatorio', 'registro_clinico.id_exploracion', 'registro_clinico.id_notasAdicionales', 'registro_clinico.id_estudios'],
            "registro_clinico",
            [['registro_clinico.id_registro', $_POST['registroId']]]
            );
        $diagnostico = dbConnection::select(['diagnostico.enfermedad', 'diagnostico.estado', 'diagnostico.notas'], "diagnostico", [['diagnostico.id_diagnostico', $cita[0]['id_diagnostico']]]);
        $info['diagnotico'] = $diagnostico[0];
        $interrogatorio = dbConnection::select(['registro_interrogatorio.motivoConsulta', 'registro_interrogatorio.sintomas'], "registro_interrogatorio", [['registro_interrogatorio.id_interrogatorio', $cita[0]['id_interrogatorio']]]);
        $info['interrogatorio'] = $interrogatorio[0];
        $exploracion = dbConnection::select(['exploracion.peso', 'exploracion.talla', 'exploracion.frecuenciaRespiratoria', 'presArterBaja', 'presArterAlta', 'temperatura', 'frecuenciaCardiaca', 'exploracionFisica'], "exploracion", [['exploracion.id_exploracion', $cita[0]['id_exploracion']]]);
        $info['exploracion'] = $exploracion[0];
        $notas_adicionales = dbConnection::select(['notas'], "notas_adicionales", [['notas_adicionales.id_notasAdicionales', $cita[0]['id_notasAdicionales']]]);
        $info['notas_adicionales'] = $notas_adicionales[0];
        $estudios = dbConnection::select(['orden'], "estudios", [['estudios.id_estudios', $cita[0]['id_estudios']]]);
        $info['estudios'] = $estudios[0];
        $tratamiento = dbConnection::select(['tratamiento.cada', 'tratamiento.inicio', 'tratamiento.indicaciones', 'medicamentos.nombre'], "tratamiento", [['tratamiento.id_registro',$_POST['registroId']]], [['medicamentos', 'tratamiento.id_medicamento', 'medicamentos.id_medicamento']]);
        $info['tratamiento'] = $tratamiento;
        return json_encode($info);
    }
    else
    {
        return 0;
    }
});