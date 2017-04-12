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
date_default_timezone_set("America/Mexico_City");
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
            if(count($antecedentes)>0)
            {
                $infoPacientes['antecedentes'] = $antecedentes[0];
                if($antecedentes[0]['id_sangre'] != null)
                {
                    $sangre = dbConnection::select(["*"], "tipo_sangre", [["tipo_sangre.id_sangre", $antecedentes[0]['id_sangre']]]);
                    $infoPacientes['sangre'] = $sangre[0];
                }
            }
            else
                $infoPacientes['antecedentes'] = [];
            
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
                if(count($dietas)>0)
                    $infoPacientes['dietas'] = $dietas[0];
            }
            if($estiloVida[0]["id_alcoholismo"] != null)
            {
                $alcoholico = dbConnection::select(["alcoholico.edad_inicio", "alcoholico.vasos"], "alcoholico", [["alcoholico.id_alcoholico", $estiloVida[0]['id_alcoholismo']]]);
                if(count($alcoholico)>0)
                    $infoPacientes['alcoholico'] = $alcoholico[0];
            }
            if($estiloVida[0]["id_exAlcoholismo"] != null)
            {
                $ex_alcoholico = dbConnection::select(["ex_alcoholico.edad_fin"], "ex_alcoholico", [["ex_alcoholico.id_exAlcoholico", $estiloVida[0]['id_exAlcoholismo']]]);
                if(count($ex_alcoholico)>0)
                    $infoPacientes['ex_alcoholico'] = $ex_alcoholico[0];
            }
            if($estiloVida[0]["id_drogas"]!= null)
            {
                $drogas = dbConnection::select(["drogas.edad_inicio", "drogas.detalles", "drogas.intravenosa"], "drogas", [["drogas.id_drogas", $estiloVida[0]['id_drogas']]]);
                if(count($drogas)>0)
                    $infoPacientes['drogas'] = $drogas[0];
            }
            if($estiloVida[0]["id_exAdicto"] != null)
            {
                $ex_adicto = dbConnection::select(["ex_adicto.edad_fin"], "ex_adicto", [["ex_adicto.id_exAdicto", $estiloVida[0]['id_exAdicto']]]);
                if(count($ex_adicto)>0)
                    $infoPacientes['exAdicto'] = $ex_adicto[0];
            }
            if($estiloVida[0]["id_fumador"] != null)
            {
                $fumador = dbConnection::select(["fumador.edad_inicio", "fumador.ciggarrosDiarios"], "fumador", [["fumador.id_fumador", $estiloVida[0]['id_fumador']]]);
                if(count($fumador)>0)
                    $infoPacientes['fumador'] = $fumador[0];
            }
            if($estiloVida[0]["id_exFumador"] != null)
            {
                $ex_fumador = dbConnection::select(["ex_fumador.edad_fin"], "ex_fumador", [["ex_fumador.id_exFumador", $estiloVida[0]['id_exFumador']]]);
                if(count($ex_fumador)>0)            
                    $infoPacientes['ex_fumador'] = $ex_fumador[0];
            }
            if($estiloVida[0]["id_cafe"] != null)
            {
                $cafe = dbConnection::select(["cafe.tazasDiarias"], "cafe", [["cafe.id_cafe", $estiloVida[0]['id_cafe']]]);
                if(count($cafe)>0)
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

Route::POST('/ajaxDgP' /* Doctor guarda Paciente*/, function() {
    
    dbConnection::update("usuarios",
        ['nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
        [$_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento'], $_POST['ocupacion']],
        [['usuarios.id_usuario', $_POST['idPaciente']]]);
    dbConnection::insert("antecedentes",
        ['id_sangre', 'tabaquismo', 'alcoholismo', 'antecedentesHereditarios', 'antecedentesPatologicos', 'antecedentesNoPatologicos'],
        [[$_POST['sangre'], $_POST['tabaquismoCantidad'], $_POST['alcoholismoCantidad'], $_POST['antecedentesHereditarios'], $_POST['antecedentesPatologicos'], $_POST['antecedentesNoPatologicos']]]);
    $antecedentes = dbConnection::lastID();
    
    dbConnection::insert("interrogatorio",
        ['antecedentesCardio', 'antecedentesDigesti', 'antecedentesEndo', 'antecedentesHemoli', 'antecedentesMuscu', 'antecedentesPiel', 'antecedentesReprod', 'antecedentesRespi', 'antecedentesNerv', 'antecedentesGener', 'antecedentesUrina'],
        [[$_POST['antecedentesCardio'], $_POST['antecedentesDigest'], $_POST['antecedentesEndocr'], $_POST['antecedentesHemo'], $_POST['antecedentesMusc'], $_POST['antecedentesPiel'],$_POST['antecedentesRepr'], $_POST['antecedentesResp'], $_POST['antecedentesNerv'], $_POST['antecedentesGene'], $_POST['antecedentesUri']]]);
    $interrogatorio = dbConnection::lastID();
    
    $ejercicio = null;
    if(isset($_POST['ejercicio']))
    {
        dbConnection::insert("ejercicio",
            ["veces_semana"],
            [[$_POST['ejercicioVecesSemana']]]);
        $ejercicio = dbConnection::lastID();
    }
    dbConnection::insert("suenio",
        ["horasDiarias"],
        [[$_POST['horasSuenio']]]);
    $suenio = dbConnection::lastID();

    if(isset($_POST['desayuna']))
    {
        dbConnection::insert("comidas",
            ["desayuno", "comidasDiarias"],
            [[1, $_POST['comidasDia']]]);
        $comidas = dbConnection::lastID();
    }
    else
    {
        dbConnection::insert("comidas",
            ["desayuno", "comidasDiarias"],
            [[0, $_POST['comidasDia']]]);
        $comidas = dbConnection::lastID();
    }
    

    $cafe = null;
    if(isset($_POST['cafe']))
    {
        dbConnection::insert("cafe",
            ["tazasDiarias"],
            [[$_POST['cafeAlDia']]]);
        $cafe = dbConnection::lastID();
    }

    $refresco = null;
    if(isset($_POST['refresco']))
    {
        dbConnection::insert("refresco",
            ["vasosDiarios"],
            [[$_POST['refrescoAlDia']]]);
        $refresco = dbConnection::lastID();
    }

    $dieta = null;
    if(isset($_POST['dieta']))
    {
        dbConnection::insert("dietas",
            ["informacionDieta"],
            [[$_POST['dietaInfo']]]);
        $dieta = dbConnection::lastID();
    }
    
    $alcohol = null;
    $exAlcohol = null;
    if(isset($_POST['alcohol']))
    {
        dbConnection::insert("alcoholico",
            ["edad_inicio", "vasos"],
            [[$_POST['alcoholEdad'], $_POST['alcoholAlDia']]]);
        $alcohol = dbConnection::lastID();
    }
    else
    {
        if(isset($_POST['exAlcoholico']))
        {
            dbConnection::insert("ex_alcoholico",
                ["edad_fin"],
                [[$_POST['exAlcoholicoEdad']]]);
            $exAlcohol = dbConnection::lastID();
        }
    }
    $fuma = null;
    $exFuma = null;
    if(isset($_POST['fuma']))
    {
        dbConnection::insert("fumador",
            ["edad_inicio", "cigarrosDiarios"],
            [[$_POST['fumaEdad'], $_POST['fumaAlDia']]]);
        $fuma = dbConnection::lastID();
    }
    else
    {
        if(isset($_POST['exFumador']))
        {
            dbConnection::insert("ex_fumador",
                ["edad_fin"],
                [[$_POST['exFumadorEdad']]]);
            $exFuma = dbConnection::lastID();
        }
    }
    $fumadorPasivo = 0;
    if(isset($_POST['fumadorPasivo']))
    {
        $fumadorPasivo = 1;
    }
    $droga = null;
    $exDroga = null;
    if(isset($_POST['droga']))
    {
        dbConnection::insert("drogas",
            ["edad_inicio", "detalles", "intravenosa"],
            [[$_POST['drogaEdad'], $_POST['drogaAnota'], $_POST['drogaIntra']]]);
        $droga = dbConnection::lastID();
    }
    else
    {
        if(isset($_POST['exAdicto']))
        {
            dbConnection::insert("ex_fumador",
                ["edad_fin"],
                [[$_POST['exAdictoEdad']]]);
            $exDroga = dbConnection::lastID();
        }
    }
    dbConnection::insert("estiloVida",
        ["id_ejercicio", "id_suenio", "id_comidas", "id_cafe", "id_refresco", "id_dietas", "id_alcoholismo", "id_exAlcoholismo", "id_drogas", "id_exAdicto", 'id_fumador', 'id_exFumador', "fumadorPasivo"],
        [[$ejercicio, $suenio, $comidas, $cafe, $refresco, $dieta, $alcohol, $exAlcohol, $droga, $exDroga, $fuma, $exFuma, $fumadorPasivo]]);
    $estiloVida = dbConnection::lastID();
    dbConnection::insert("alergias",
        ["descripcion"],
        [[$_POST['alergias']]]);
    $alergias = dbConnection::lastID();
    dbConnection::update("pacientes",
        ['id_antecedentes', 'id_interrogatorio', 'id_alergias', 'id_estiloVida'],
        [$antecedentes, $interrogatorio, $alergias, $estiloVida],
        [['pacientes.id_usuario', $_POST['idPaciente']]]);
    
    dbConnection::RAW("DELETE FROM antecedentes WHERE id_antecedentes NOT IN (SELECT id_antecedentes FROM pacientes)");
    dbConnection::RAW("DELETE FROM interrogatorio WHERE id_interrogatorio NOT IN (SELECT id_interrogatorio FROM pacientes)");
    dbConnection::RAW("DELETE FROM alergias WHERE id_alergias NOT IN (SELECT id_alergias FROM pacientes)");
    dbConnection::RAW("DELETE FROM estilovida WHERE id_estiloVida NOT IN (SELECT id_estiloVida FROM pacientes)");
    
    dbConnection::RAW("DELETE FROM ejercicio WHERE id_ejercicio NOT IN (SELECT id_ejercicio FROM estilovida)");
    dbConnection::RAW("DELETE FROM suenio WHERE id_suenio NOT IN (SELECT id_suenio FROM estilovida)");
    dbConnection::RAW("DELETE FROM comidas WHERE id_comidas NOT IN (SELECT id_comidas FROM estilovida)");
    dbConnection::RAW("DELETE FROM cafe WHERE id_cafe NOT IN (SELECT id_cafe FROM estilovida)");
    dbConnection::RAW("DELETE FROM refresco WHERE id_refresco NOT IN (SELECT id_refresco FROM estilovida)");
    dbConnection::RAW("DELETE FROM dietas WHERE id_dietas NOT IN (SELECT id_dietas FROM estilovida)");
    dbConnection::RAW("DELETE FROM alcoholico WHERE id_alcoholico NOT IN (SELECT id_alcoholismo FROM estilovida)");
    dbConnection::RAW("DELETE FROM ex_alcoholico WHERE id_exAlcoholico NOT IN (SELECT id_exAlcoholismo FROM estilovida)");
    dbConnection::RAW("DELETE FROM drogas WHERE id_drogas NOT IN (SELECT id_drogas FROM estilovida)");
    dbConnection::RAW("DELETE FROM ex_adicto WHERE id_exAdicto NOT IN (SELECT id_exAdicto FROM estilovida)");
    dbConnection::RAW("DELETE FROM fumador WHERE id_fumador NOT IN (SELECT id_fumador FROM estilovida)");
    dbConnection::RAW("DELETE FROM ex_fumador WHERE id_exFumador NOT IN (SELECT id_exFumador FROM estilovida)");

});

Route::POST('/ajaxRC' /* Recepcionista obtiene Citas */, function() {
    $idDoc = $_POST['idDoc'];
    $date = $_POST['date'];
    $disponible = $_POST['disp'] == "true" ? true : false;
    $Hoy = date("N");
    $horario = dbConnection::select(["horario_trabajo", "tiempo_consulta"], "medicos", [["id_usuario", $idDoc]], [], "LIMIT 1");
    $tiempoConsulta = $horario[0]['tiempo_consulta'];
    $horario = $horario[0]['horario_trabajo'];
    preg_match('/\(/',$horario, $par, PREG_OFFSET_CAPTURE);
    $inicio = $par[0][1] + 1;
    preg_match('/-/',$horario, $guion, PREG_OFFSET_CAPTURE);
    $fin = $guion[0][1]- $inicio;
    $horaStart = substr($horario, $inicio, $fin);
    $inicio2= $guion[0][1] + 1;
    preg_match('/\)/',$horario, $par2, PREG_OFFSET_CAPTURE);
    $fin2 = $par2[0][1] - $inicio2;
    $horaFin = substr($horario, $inicio2, $fin2);
    $consulta = dbConnection::select(["DATE_FORMAT(citas.fecha_hora, '%Y-%m-%d') as fecha", "DATE_FORMAT(citas.fecha_hora,'%H:%i:%s') as hora", "tipocita.nombre as tipo", "usuarios.nombre", "usuarios.id_usuario", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno", "usuarios.usuario"],
        "citas",
        [["citas.id_medico", $idDoc], ["DATE_FORMAT(citas.fecha_hora, '%Y-%m-%d')", $date]],
        [["tipocita", "citas.tipo", "tipocita.id"], ["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
    $datos["data"] = [];
    if($disponible)
    {   
        $time = $horaStart;
         $conteo = 0;
        while(strtotime($time)<strtotime($horaFin))
        {
            $comprobacion = true;
            foreach($consulta as $c)
            {
                if($c['hora']== $time)
                    $comprobacion = false;
            }
            if($comprobacion)
            {
                array_push($datos["data"],["Seleccionar"=> '<input type="radio" name="optradio" values="-1"/>', "Paciente" => "DISPONIBLE", "Usuario" => "DISPONIBLE", "Tipo" => "DISPONIBLE", "Hora" => $time]);
            }
            $time = strtotime("+".$tiempoConsulta." minutes",strtotime($time));
            $time = date("H:i:s", $time);
            $conteo++;
        }
        
    }
    else
    {
         $time = $horaStart;
         $conteo = 0;
        while(strtotime($time)<strtotime($horaFin))
        {
            $comprobacion = true;
            foreach($consulta as $c)
            {
                if($c['hora']== $time)
                {
                    array_push($datos["data"],["Seleccionar"=> '<input type="radio" name="optradio" values="'.$c['id_usuario'].'"/>', "Paciente" => $c['nombre'] . " " . $c['apellidoPaterno'] . " " . $c['apellidoMaterno'], "Usuario" => $c['usuario'], "Tipo" => $c['tipo'], "Hora" => $c['hora']]);
                    $comprobacion = false;
                }
            }
            if($comprobacion)
            {
                array_push($datos["data"],["Seleccionar"=> '<input type="radio" name="optradio" values="-1"/>', "Paciente" => "DISPONIBLE", "Usuario" => "DISPONIBLE", "Tipo" => "DISPONIBLE", "Hora" => $time]);
            }
            $time = strtotime("+".$tiempoConsulta." minutes",strtotime($time));
            $time = date("H:i:s", $time);
            $conteo++;
        }
        
    }
    echo json_encode($datos);

});