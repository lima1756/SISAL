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

Route::get('/dashboard/Personal', function () {
  return view('admin/Personal');
});
Route::get('/dashboard/medicine', function () {
  return view('admin/medicine');
});


Route::post('/logIn', function () {
    if(logData::logIn($_POST['email'], $_POST['pass']))
    {
        $id = logData::getData("id_usuario");
        $check = false;
        if(Type::isMedic())
        {
            $check = dbConnection::select(["estado"], "medicos", [["id_usuario", $id]])[0]['estado']==1?true:false;
        }
        elseif(Type::isPatient())
        {
            $check = dbConnection::select(["estado"], "pacientes", [["id_usuario", $id]])[0]['estado']==1?true:false;
        }
        elseif(Type::isReceptionist())
        {
            $check = dbConnection::select(["estado"], "recepcionistas", [["id_usuario", $id]])[0]['estado']==1?true:false;
        }
        elseif(Type::isAdmin())
        {
            $check = true;
        }
        elseif(Type::isInCharge())
        {
            $check = count(dbConnection::select(["id_paciente"], "encargados", [["id_paciente", 0, ">"]]))>0?true:false;
            if($check)
            {
                $id = dbConnection::select(["*"], "encargados", [['id_usuario', $id]])[0]['id_paciente'];
                $check = dbConnection::select(["estado"], "pacientes", [["id_usuario", $id]])[0]['estado']==1?true:false;
            }
        }
        if($check)
            return redirect('/dashboard');
        else
        {
            logData::logOut();
            return redirect('/?error=denied');   
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
    elseif(Type::isInCharge())
    {
        return view('patient/index');
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
Route::get('/dashboard/doctors', function () {
   
        return view('patient/doctors');
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
    elseif(Type::isInCharge())
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

Route::get('/dashboard/clinic', function () {
    if(Type::isMedic())
    {
        return view('doctor/clinic');
    }
    elseif(Type::isPatient())
    {
        return view('patient/clinic');
    }
    elseif(Type::isInCharge())
    {
        return view('patient/clinic');
    }
    elseif(Type::isReceptionist())
    {
        return view('receptionist/clinic');
    }
    elseif(Type::isAdmin())
    {
        return view('admin/clinic');
    }
    else
    {
        return redirect('/dashboard');
    }
});

Route::get('/dashboard/userProfile', function () {
   if(Type::isMedic())
    {
        return view('doctor/userProfile');
    }
    elseif(Type::isPatient())
    {
        return view('patient/userProfile');
    }
    elseif(Type::isReceptionist())
    {
        return view('receptionist/userProfile');
    }
    elseif(Type::isAdmin())
    {
        return view('admin/userProfile');
    }
    elseif(Type::isInCharge())
    {
        return view('patient/userProfile');
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
        $multiplier = 1;
        if($_POST['medCada'][$x]==0){
            $multiplier = 0;
            $_POST['medDura'] = 0;
        }
        if($_POST['medDuraValue'][$x]=="hora")
            $multiplier = 1;
        elseif($_POST['medDuraValue'][$x]=="dias")
            $multiplier = 24;
        elseif($_POST['medDuraValue'][$x]=="semanas")
            $multiplier = 24*7;
        elseif($_POST['medDuraValue'][$x]=="meses")
            $multiplier = 24*31;
        elseif($_POST['medDuraValue'][$x]=="siempre")
        {
            $multiplier = 24*365*100;
        }
        if($_POST['medDura'][$x] != NULL)
        {
            if($_POST['medID'][$x]!=0)
            {
                dbConnection::insert("tratamiento", ["id_medicamento", "cada", "inicio", "durante", "indicaciones", "id_registro"], 
                    [[$_POST['medID'][$x], $_POST['medCada'][$x], $_POST['medStart'][$x], $_POST['medDura'][$x]*$multiplier, $_POST['medIndi'][$x], $idRegistro]]);
            }
            else
            {
                
                
                dbConnection::insert("medicamentos", ["nombre", "aprobada"], 
                    [[$_POST['medName'][$x],null]]);
                $idMed = dbConnection::lastID();
                
                dbConnection::insert("tratamiento", ["id_medicamento", "cada", "inicio", "durante", "indicaciones", "id_registro"], 
                    [[$idMed, $_POST['medCada'][$x], $_POST['medStart'][$x], $_POST['medDura'][$x]*$multiplier,$_POST['medIndi'][$x], $idRegistro]]);
            }
        }
        else
        {
            if($_POST['medID'][$x]!=0)
            {
                dbConnection::insert("tratamiento", ["id_medicamento", "cada", "inicio", "durante", "indicaciones", "id_registro"], 
                    [[$_POST['medID'][$x], $_POST['medCada'][$x], $_POST['medStart'][$x], $multiplier, $_POST['medIndi'][$x], $idRegistro]]);
            }
            else
            {
                
                
                dbConnection::insert("medicamentos", ["nombre", "aprobada"], 
                    [[$_POST['medName'][$x],null]]);
                $idMed = dbConnection::lastID();
                
                dbConnection::insert("tratamiento", ["id_medicamento", "cada", "inicio", "durante", "indicaciones", "id_registro"], 
                    [[$idMed, $_POST['medCada'][$x], $_POST['medStart'][$x], $multiplier,$_POST['medIndi'][$x], $idRegistro]]);
            }
        }
    }
    
    return redirect('/dashboard/patients');
});

Route::match(["get", "post"],'/dashboard/patients', function() {
    if(Type::isMedic())
    {
        return view('doctor/patients');
    }
    elseif(Type::isReceptionist())
    {
        return view('receptionist/patients');
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

Route::post('/recetamedica', function() {
   try {
    ob_start();

$regmed = $_POST['medico']; 
$idCita = $_POST['fechaCita'];  
$valores=["id_paciente", "id_medico","id_diagnostico","id_registro","fecha_hora"];
$tabla="registro_clinico";
$where=[["registro_clinico.id_registro",$idCita]];
$join=[];
$datos1 = dbConnection::select($valores,$tabla,$where,$join);



$v1 = $datos1[0]['id_paciente'];
$valores=["nombre", "apellidoPaterno", "apellidoMaterno","email"];
$tabla="usuarios";
$where=[["id_usuario",$v1]];
$join=[];
$datos = dbConnection::select($valores,$tabla,$where,$join);

$v11 = $datos1[0]['id_medico'];
$valores=["especialidad", "cedula", "universidad"];
$tabla="medicos";
$where=[["id_usuario",$v11]];
$join=[];
$doctor = dbConnection::select($valores,$tabla,$where,$join);

$v111 = $datos1[0]['id_medico'];
$valores=["nombre", "apellidoPaterno", "apellidoMaterno"];
$tabla="usuarios";
$where=[["id_usuario",$v111]];
$join=[];
$doctorname = dbConnection::select($valores,$tabla,$where,$join);




$valu = $datos1[0]['id_registro'];
$valores=["id_medicamento","durante","cada", "inicio","indicaciones"];
$tabla="tratamiento";
$where=[["id_registro",$valu]];
$join=[];
$datos3 = dbConnection::select($valores,$tabla,$where,$join);


?>

<!DOCTYPE html>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Receta</title>

  </head>
  <body style="position:relative;width:21cm;height:29.7cm;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;color:#001028;background-color:#FFFFFF;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;font-family:Arial;font-size:12px;" >
    <div id="header" class="clearfix" style="padding-top:10px;padding-bottom:10px;padding-right:0;padding-left:0;margin-bottom:30px;" >
      <div id="logo" style="text-align:center;margin-bottom:10px;" >
        <img src="./res/CSALogo.png" style="width:250px;" >
      </div>
      <h1 style="border-top-width:1px;border-top-style:solid;border-top-color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#5D6975;color:#5D6975;font-size:2.4em;line-height:1.4em;font-weight:normal;text-align:center;margin-top:0;margin-bottom:20px;margin-right:0;margin-left:0;background-color:transparent;background-image:url(dimension.png);background-repeat:repeat;background-position:top left;background-attachment:scroll;" >Receta médica</h1>
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <tr>
      <td>

      </td>
      </tr> 
    
    </table>
    </div>
 <div>   
<table>
        <thead>
          <tr>
            <th class="service" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Doctor:</th>
            <th class="desc" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Especialidad:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Cedula:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Universidad:</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $doctorname[0]['nombre']. " " .$doctorname[0]['apellidoPaterno']. " " .$doctorname[0]['apellidoMaterno'];?></td>
            <td class="desc" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $doctor[0]['especialidad'];?></td>
            <td class="unit" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo $doctor[0]['cedula'];?></td>
            <td class="qty" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo $doctor[0]['universidad'];?></td>
          </tr>
        </tbody>
      </table>
</div>


 <div>   
<table>
        <thead>
          <tr>
            <th class="service" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Paciente:</th>
            <th class="desc" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Correo:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Fecha:</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $datos[0]['nombre']. " " .$datos[0]['apellidoPaterno']. " " .$datos[0]['apellidoMaterno'];?></td>
            <td class="desc" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $datos[0]['email'];?></td>
            <td class="unit" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo date("d-m-Y", strtotime($datos1[0]['fecha_hora']));?></td>
          </tr>
        </tbody>
      </table>
</div>


    <div>
      <table>
        <thead>
          <tr>
            <th class="service" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Nombre Medicina:</th>
            <th class="desc" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Cada:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Durante:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Inicio de toma:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Indicaciones extra:</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          foreach($datos3 as $da): 
          $nom = dbConnection::RAW("SELECT nombre from medicamentos where id_medicamento  = '".$da['id_medicamento']."'");
          ?>
          <tr>
            <td class="service" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $nom[0]['nombre'];?></td>
            <td class="desc" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php if($da['cada']==0) echo '-'; else echo $da['cada'];?></td>
            <td class="unit" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php if($da['durante']==24*365*100) echo 'Siempre'; elseif($da['cada']==0) echo "una toma"; else echo $da['durante'];?></td>
            <td class="qty" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo date("d-m-Y H:i", strtotime($da['inicio']));?></td>
            <td class="total" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo $da['indicaciones'];?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br><br>
      <div id="notices">
        <div>Firma doctor:</div>
        <br><br>
        <div class="notice" style="color:#5D6975;font-size:1.2em;" >____________________________________________________________________________________________________________</div>
      </div>
     </div>
      <div id="company" class="clearfix" style="float:left;text-align:left;" >
        <div style="white-space:nowrap;" >                       </div>
        <div style="white-space:nowrap;" >Clinica San Antonio</div>
        <div style="white-space:nowrap;" >Av. Independencia 1748 Pte.<br /> Los Mochis, Sianaloa.</div>
        <div style="white-space:nowrap;" >(668) 812-1348</div>
        <div style="white-space:nowrap;" >(044) 6681-30-2436</div>
        <div style="white-space:nowrap;" ><a href="mailto:brucamer@gmail.com" style="color:#5D6975;text-decoration:underline;" >brucamer@gmail.com</a></div>
      </div>

    <div id="footer"style="color:#5D6975;width:100%;height:30px;position:absolute;bottom:0;border-top-width:1px;border-top-style:solid;border-top-color:#C1CED9;padding-top:8px;padding-bottom:8px;padding-right:0;padding-left:0;text-align:center;" >
      SISAL 2017.
    </div>
  </body>
</html>
<?php
    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('P', 'A4', 'fr');//H o P dependiendo de como se necesite
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('Receta.pdf');//D si se desea descargar
    } catch (Html2PdfException $e) {
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getHtmlMessage();
    }
});

Route::post('/recetamedica1', function() {
   return view('disenio');
});
//FIN Receta PDF


Route::POST('/ajaxDP', function() {
    if(Type::isMedic())
    {
        $infoPacientes = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
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
            

        }
        return json_encode($infoPacientes);
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
        [$_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['Domicilio'], $_POST['codigoPostal'], $_POST['domTel'], $_POST['celTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento'], $_POST['ocupacion']],
        [['usuarios.id_usuario', $_POST['idPaciente']]]);
    dbConnection::insert("antecedentes",
        ['id_sangre', 'tabaquismo', 'alcoholismo', 'antecedentesHereditarios', 'antecedentesPatologicos', 'antecedentesNoPatologicos'],
        [[$_POST['sangre'], isset($_POST['tabaquismoCantidad'])?$_POST['tabaquismoCantidad']:null, isset($_POST['alcoholismoCantidad'])?$_POST['alcoholismoCantidad']:null, $_POST['antecedentesHereditarios'], $_POST['antecedentesPatologicos'], $_POST['antecedentesNoPatologicos']]]);
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
    
    dbConnection::RAW("DELETE FROM antecedentes WHERE id_antecedentes NOT IN (SELECT id_antecedentes FROM pacientes)", true);
    dbConnection::RAW("DELETE FROM interrogatorio WHERE id_interrogatorio NOT IN (SELECT id_interrogatorio FROM pacientes)", true);
    dbConnection::RAW("DELETE FROM alergias WHERE id_alergias NOT IN (SELECT id_alergias FROM pacientes)", true);
    dbConnection::RAW("DELETE FROM estilovida WHERE id_estiloVida NOT IN (SELECT id_estiloVida FROM pacientes)", true);
    
    dbConnection::RAW("DELETE FROM ejercicio WHERE id_ejercicio NOT IN (SELECT id_ejercicio FROM estiloVida)", true);
    
    dbConnection::RAW("DELETE FROM suenio WHERE id_suenio NOT IN (SELECT id_suenio FROM estiloVida)", true);
    
    dbConnection::RAW("DELETE FROM comidas WHERE id_comidas NOT IN (SELECT id_comidas FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM cafe WHERE id_cafe NOT IN (SELECT id_cafe FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM refresco WHERE id_refresco NOT IN (SELECT id_refresco FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM dietas WHERE id_dietas NOT IN (SELECT id_dietas FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM alcoholico WHERE id_alcoholico NOT IN (SELECT id_alcoholismo FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM ex_alcoholico WHERE id_exAlcoholico NOT IN (SELECT id_exAlcoholismo FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM drogas WHERE id_drogas NOT IN (SELECT id_drogas FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM ex_adicto WHERE id_exAdicto NOT IN (SELECT id_exAdicto FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM fumador WHERE id_fumador NOT IN (SELECT id_fumador FROM estiloVida)", true);
    dbConnection::RAW("DELETE FROM ex_fumador WHERE id_exFumador NOT IN (SELECT id_exFumador FROM estiloVida)", true);

});

Route::POST('/ajaxRC' /* Recepcionista obtiene Citas */, function() {
    $idDoc = $_POST['idDoc'];
    $futuras = $_POST['futuras'] == "true" ? true : false;
    $datos = array();
    
    if($futuras)
    {
        if($idDoc=="")
        {   
            $consulta = dbConnection::RAW("SELECT DATE_FORMAT(citas.fecha_hora, '%d/%m/%Y') as fecha, citas.id_cita, DATE_FORMAT(citas.fecha_hora,'%H:%i:%s') as hora, tipocita.nombre as tipo, usuarios.nombre, usuarios.id_usuario, usuarios.apellidoPaterno, usuarios.apellidoMaterno, usuarios.usuario FROM citas INNER JOIN tipocita ON citas.tipo = tipocita.id INNER JOIN usuarios ON usuarios.id_usuario = citas.id_paciente WHERE fecha_hora>=CURDATE();");        
            $datos["data"] = array();
            foreach($consulta as $c)
            {
                array_push($datos["data"],["Seleccionar"=> $c['id_cita'], "Paciente" => $c['nombre'] . " " . $c['apellidoPaterno'] . " " . $c['apellidoMaterno'], "celular" => $c['celular'], "Tipo" => $c['tipo'], "Hora" => $c['fecha']." ".$c['hora']]);
            }
            return json_encode($datos);
        }
        else
        {
            $consulta = dbConnection::RAW("SELECT DATE_FORMAT(citas.fecha_hora, '%d/%m/%Y') as fecha, citas.id_cita, DATE_FORMAT(citas.fecha_hora,'%H:%i:%s') as hora, tipocita.nombre as tipo, usuarios.nombre, usuarios.id_usuario, usuarios.apellidoPaterno, usuarios.apellidoMaterno, usuarios.telefonoCelular as celular FROM citas INNER JOIN tipocita ON citas.tipo = tipocita.id INNER JOIN usuarios ON usuarios.id_usuario = citas.id_paciente WHERE fecha_hora>=CURDATE() AND citas.id_medico = $idDoc;");        
            $datos["data"] = array();
            foreach($consulta as $c)
            {
                array_push($datos["data"],["Seleccionar"=> $c['id_cita'], "Paciente" => $c['nombre'] . " " . $c['apellidoPaterno'] . " " . $c['apellidoMaterno'], "celular" => $c['celular'], "Tipo" => $c['tipo'], "Hora" => $c['fecha']." ".$c['hora']]);
            }
            return json_encode($datos);
        }

    }
    if($idDoc!="")
    {
        $date = $_POST['date'];
        $disponible = $_POST['disp'] == "true" ? true : false;
        $Hoy = date("N", strtotime($date));
        $Hoy = $Hoy == 1 ? "l" : ($Hoy == 2 ? "m" : ($Hoy == 3 ? "x" : ($Hoy == 4 ? "j" : ($Hoy == 5 ? "v" : ($Hoy == 6 ? "s" : "d")))));
        $horario = dbConnection::select(["horario_trabajo", "tiempo_consulta"], "medicos", [["id_usuario", $idDoc]], [], "LIMIT 1");
        $tiempoConsulta = $horario[0]['tiempo_consulta'];
        $horario = $horario[0]['horario_trabajo'];
        $hoyTrabaja = strpos($horario, $Hoy) !== false ? true: false;
        preg_match('/\(/',$horario, $par, PREG_OFFSET_CAPTURE);
        $inicio = $par[0][1] + 1;
        preg_match('/-/',$horario, $guion, PREG_OFFSET_CAPTURE);
        $fin = $guion[0][1]- $inicio;
        $horaStart = substr($horario, $inicio, $fin);
        $inicio2= $guion[0][1] + 1;
        preg_match('/\)/',$horario, $par2, PREG_OFFSET_CAPTURE);
        $fin2 = $par2[0][1] - $inicio2;
        $horaFin = substr($horario, $inicio2, $fin2);
        $consulta = dbConnection::select(["DATE_FORMAT(citas.fecha_hora, '%Y-%m-%d') as fecha", "citas.id_cita", "DATE_FORMAT(citas.fecha_hora,'%H:%i:%s') as hora", "tipocita.nombre as tipo", "usuarios.telefonoCelular as celular", "usuarios.id_usuario", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno", "usuarios.nombre"],
            "citas",
            [["citas.id_medico", $idDoc], ["DATE_FORMAT(citas.fecha_hora, '%Y-%m-%d')", $date]],
            [["tipocita", "citas.tipo", "tipocita.id"], ["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
        $datos["data"] = [];
        $datos["hoyTrabaja"] = $hoyTrabaja;
        $datos["horario"] = $horario;
        $datos["hoy"] = $Hoy;
        $time = $horaStart;
        if(sizeof($time)==4)
            $time = "0".$time;
            $conteo = 0;
        if(strtotime($date)<time())
        {
                foreach($consulta as $c)
                {
                            array_push($datos["data"],["Seleccionar"=> $c['id_cita'], "Paciente" => $c['nombre'] . " " . $c['apellidoPaterno'] . " " . $c['apellidoMaterno'], "celular" => $c['celular'], "Tipo" => $c['tipo'], "Hora" => $c['hora']]);
                            $comprobacion = false;
                            $tiempoExtra = $c['hora'];
                }
        }
        elseif($disponible)
        {   
            while(strtotime($time)<strtotime($horaFin) && $conteo!=10000)
            {
                $comprobacion = true;
                foreach($consulta as $c)
                {
                    if((strtotime($c['hora']) >= strtotime($time) && strtotime($c['hora']) < strtotime("+".$tiempoConsulta." minutes",strtotime($time))) || (strtotime($c['hora']) > strtotime($time) && strtotime($c['hora']) < strtotime("+".$tiempoConsulta." minutes",strtotime($time))))
                        {
                            $comprobacion = false;
                            $tiempoExtra = $c['hora'];
                        }
                }
                if($comprobacion && $hoyTrabaja)
                {
                    if(sizeof($time)==4)
                        $time = "0".$time;
                    array_push($datos["data"],["Seleccionar"=> $date.' '.$time, "Paciente" => "DISPONIBLE", "celular" => "DISPONIBLE", "Tipo" => "DISPONIBLE", "Hora" => $time]);
                    $time = strtotime("+".$tiempoConsulta." minutes",strtotime($time));
                    $time = date("H:i:s", $time);
                }
                elseif(!$comprobacion)
                {
                    if(sizeof($time)==4)
                        $time = "0".$time;
                    $time = strtotime("+".$tiempoConsulta." minutes",strtotime($tiempoExtra));
                    $time = date("H:i:s", $time);
                }
                $conteo++;
            }
        }
        else
        {
            while(strtotime($time)<strtotime($horaFin) && $conteo!=1000)
            {
                $comprobacion = true;
                foreach($consulta as $c)
                {
                    if((strtotime($c['hora']) >= strtotime($time) && strtotime($c['hora']) < strtotime("+".$tiempoConsulta." minutes",strtotime($time))) || (strtotime($c['hora']) > strtotime($time) && strtotime($c['hora']) < strtotime("+".$tiempoConsulta." minutes",strtotime($time))))
                    {
                        array_push($datos["data"],["Seleccionar"=> $c['id_cita'], "Paciente" => $c['nombre'] . " " . $c['apellidoPaterno'] . " " . $c['apellidoMaterno'], "celular" => $c['celular'], "Tipo" => $c['tipo'], "Hora" => $c['hora']]);
                        $comprobacion = false;
                        $tiempoExtra = $c['hora'];
                    }
                }
                if($comprobacion && $hoyTrabaja)
                {
                    if(sizeof($time)==4)
                        $time = "0".$time;
                    array_push($datos["data"],["Seleccionar"=> $date.' '.$time, "Paciente" => "DISPONIBLE", "celular" => "DISPONIBLE", "Tipo" => "DISPONIBLE", "Hora" => $time]);
                    $time = strtotime("+".$tiempoConsulta." minutes",strtotime($time));
                    $time = date("H:i:s", $time);
                }
                elseif(!$comprobacion)
                {
                    if(sizeof($time)==4)
                        $time = "0".$time;
                    $time = strtotime("+".$tiempoConsulta." minutes",strtotime($tiempoExtra));
                    $time = date("H:i:s", $time);
                }
                $conteo++;
            }
            
        }
        return json_encode($datos);
    }
    else
    {
        $consulta = dbConnection::RAW("SELECT DATE_FORMAT(citas.fecha_hora, '%d/%m/%Y') as fecha, citas.id_cita, DATE_FORMAT(citas.fecha_hora,'%H:%i:%s') as hora, tipocita.nombre as tipo, usuarios.nombre, usuarios.id_usuario, usuarios.apellidoPaterno, usuarios.apellidoMaterno, usuarios.telefonoCelular as celular FROM citas INNER JOIN tipocita ON citas.tipo = tipocita.id INNER JOIN usuarios ON usuarios.id_usuario = citas.id_paciente WHERE DATE(fecha_hora)>DATE(NOW());");
        $datos["data"] = [];
        foreach($consulta as $c)
        {
            array_push($datos["data"],["Seleccionar"=> $c['id_cita'], "Paciente" => $c['nombre'] . " " . $c['apellidoPaterno'] . " " . $c['apellidoMaterno'], "celular" => $c['celular'], "Tipo" => $c['tipo'], "Hora" => $c['fecha']." ".$c['hora']]);
        }
        return json_encode($datos);
    }
});


Route::POST('/ajaxRDC' /* Recepcionista obtiene Datos de Cita*/, function() {
    $idDate = $_POST['citaId'];
    $datos = dbConnection::select( 
        ["fecha_hora", "tipocita.nombre as tipo", "usuarios.nombre", "usuarios.usuario", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"],
        "citas", 
        [["citas.id_cita", $idDate]],
        [["tipocita", "tipocita.id", "citas.tipo"], ["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
    $doctor = dbConnection::select( 
        ["usuarios.nombre", "usuarios.usuario", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"],
        "citas", 
        [["citas.id_cita", $idDate]],
        [["usuarios", "usuarios.id_usuario", "citas.id_medico"]]);
    $datos[0]["medico"]=$doctor[0];
    return json_encode($datos[0]);
});

Route::POST('/eliminarCita', function() {
    $datoCita = dbConnection::select(["*"], "citas", [["id_cita", $_POST['idCitaCancelacion']]]);
    $datoCita = $datoCita[0];
    $datoCita['razon'] = $_POST['razon'];
    dbConnection::insert("canceladas", ["id_cita", "id_paciente", "id_recepcionista", "id_medico", "fecha_hora", "razon"] ,[[$datoCita['id_cita'], $datoCita['id_paciente'], $datoCita['id_recepcionista'], $datoCita['id_medico'], $datoCita['fecha_hora'], $datoCita['razon']]]);
    dbConnection::delete("citas", [["id_cita", $_POST['idCitaCancelacion']]]);
    return redirect("/dashboard/dates?date=".$datoCita['fecha_hora']."&med=".$datoCita['id_medico']);
});

Route::POST('/nuevaCita', function() {
    if(isset($_POST['usuario']))
    {
        dbConnection::insert("citas", ["id_paciente", "id_recepcionista", "id_medico", "fecha_hora", "tipo"],
        [[$_POST['usuario'], logData::getData("id_usuario"), $_POST['id_medico'], $_POST['fecha_hora'], $_POST['selectTipoCita']]]);
    }
    else
    {
        $cipher_pass = hash("sha256", $_POST['pass']);
        dbConnection::insert("usuarios",
            ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'telefonoDomiciliar', 'telefonoCelular'],
            [[$_POST['userNuevo'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domTel'], $_POST['ofTel']]]
            );
        $idPaciente = dbConnection::lastID();
        dbConnection::insert("pacientes", ["id_usuario"], [[$idPaciente]]);
        dbConnection::insert("citas", ["id_paciente", "id_recepcionista", "id_medico", "fecha_hora", "tipo"],
        [[$idPaciente, logData::getData("id_usuario"), $_POST['id_medico'], $_POST['fecha_hora'], $_POST['selectTipoCita']]]);
    }
    return redirect("/dashboard/dates?date=".$_POST['fecha_hora']."&med=".$_POST['id_medico']);
});


Route::POST('/ajaxRP' /* Recepcionista obtiene Paciente*/, function() {
    if(Type::isReceptionist())
    {
        $infoPacientes = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.ciudad", "usuarios.estado", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar"], 
            "usuarios", 
            [["usuarios.id_usuario", $_POST['patientId']]]
            );
        $infoPacientes['generales'] = $generales[0];
        $responsable = dbConnection::select(["encargados.id_usuario" , "usuarios.usuario", "usuarios.ciudad", "usuarios.estado", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar"], 
            "encargados", 
            [["encargados.id_paciente", $_POST['patientId']]],
            [["usuarios", "encargados.id_usuario", "usuarios.id_usuario"]]
            );
        if(count($responsable)>0)
        {
            $infoPacientes['encargados'] = $responsable[0];
        }
        
        return json_encode($infoPacientes);
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxMA' /* Medicina Aprobada*/, function() {
    if(Type::isAdmin())
    {
    
    dbConnection::update("medicamentos",
                ['nombre', 'aprobada', 'id_medicamento'],
                [$_POST['nombre'],'1', $_POST['ID']],
                [['medicamentos.id_medicamento', $_POST['ID']]]
            );
        
    }
    else{
        return 0;
    }

});

Route::POST('/ajaxMR' /* Medicina Rechazada*/, function() {
if(Type::isAdmin())
    {
    dbConnection::update("medicamentos",
                ['nombre', 'aprobada', 'id_medicamento'],
                [$_POST['nombre'],'0', $_POST['ID']],
                [['medicamentos.id_medicamento', $_POST['ID']]]
            );  
    
      }
    else{
        return 0;
    }

});

Route::POST('/ajaxAeD' /* Admin elimina doctor*/, function() {
if(Type::isAdmin())
    {
    dbConnection::update("medicos",
                ['estado'],
                ['0'],
                [['medicos.id_usuario', $_POST['ID']]]
            );    
    
      }
    else{
        return 0;
    }

});


Route::POST('/ajaxAeR' /* Admin elimina recepcionista*/, function() {

if(Type::isAdmin())
    {
    dbConnection::update("recepcionistas",
                ['estado'],
                ['0'],
                [['recepcionistas.id_usuario', $_POST['ID']]]
            );  
    
      }
    else{
        return 0;
    }
});

Route::POST('/ajaxAaD' /* Admin da de alta doctor*/, function() {
if(Type::isAdmin())
    {
    dbConnection::update("medicos",
                ['estado'],
                ['1'],
                [['medicos.id_usuario', $_POST['ID']]]
            );    
    
      }
    else{
        return 0;
    }

});


Route::POST('/ajaxAaR' /* Admin da de alta recepcionista*/, function() {
if(Type::isAdmin())
    {

    dbConnection::update("recepcionistas",
                ['estado'],
                ['1'],
                [['recepcionistas.id_usuario', $_POST['ID']]]
            );  
    
      }
    else{
        return 0;
    }
});


Route::POST('/ajaxAD' /* Admin obtiene Doctor*/, function() {
    if(Type::isAdmin())
    {
        $infoDoctor = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar"], 
            "usuarios", 
            [["usuarios.id_usuario", $_POST['personalId']]]
            );
        $infoDoctor['generales'] = $generales[0];
        $adic = dbConnection::select(["usuarios.id_usuario" , "medicos.domicilioConsultorio", "medicos.telEmergencias", "medicos.celEmergencias","medicos.estado",
                "medicos.emailEmergencias", "medicos.facebook", "medicos.twitter", "medicos.horario_trabajo", "medicos.tiempo_consulta", "medicos.especialidad", "medicos.universidad", "medicos.cedula"], 
            "medicos", 
            [["medicos.id_usuario", $_POST['personalId']]],
            [["usuarios", "medicos.id_usuario", "usuarios.id_usuario"]]
            );
            $infoDoctor['adicional'] = $adic[0];
        
        return json_encode($infoDoctor);
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxAR' /* Admin obtiene Recepcionista*/, function() {
    if(Type::isAdmin())
    {
        $infoRecep = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar"], 
            "usuarios", 
            [["usuarios.id_usuario", $_POST['personalId']]]
            );
        $infoRecep['generales'] = $generales[0];
            $adic = dbConnection::select(["recepcionistas.estado"], 
            "recepcionistas", 
            [["recepcionistas.id_usuario", $_POST['personalId']]],
            [["usuarios", "recepcionistas.id_usuario", "usuarios.id_usuario"]]
            );
            $infoRecep['adicional'] = $adic[0];

        return json_encode($infoRecep);
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxPD' /* Paciente obtiene Doctor*/, function() {
    if(Type::isPatient())
    {
        $infoDoctor = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar"], 
            "usuarios", 
            [["usuarios.id_usuario", $_POST['personalId']]]
            );
        $infoDoctor['generales'] = $generales[0];
        $adic = dbConnection::select(["usuarios.id_usuario" ,"medicos.estado", "medicos.domicilioConsultorio", "medicos.telEmergencias", "medicos.celEmergencias",
                "medicos.emailEmergencias", "medicos.facebook", "medicos.twitter", "medicos.horario_trabajo", "medicos.tiempo_consulta", "medicos.especialidad", "medicos.universidad"], 
            "medicos", 
            [["medicos.id_usuario", $_POST['personalId']]],
            [["usuarios", "medicos.id_usuario", "usuarios.id_usuario"]]
            );
            $infoDoctor['adicional'] = $adic[0];
        
        return json_encode($infoDoctor);
    }
    elseif(Type::isInCharge())
    {
        $infoDoctor = array();
        $generales = dbConnection::select(["usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno",
                "usuarios.codigoPostal", "usuarios.Domicilio", "usuarios.email", "usuarios.fechaNacimiento", "usuarios.genero", "usuarios.noSeguroSocial", "usuarios.Ocupacion", 
                "usuarios.telefonoCelular", "usuarios.telefonoDomiciliar"], 
            "usuarios", 
            [["usuarios.id_usuario", $_POST['personalId']]]
            );
        $infoDoctor['generales'] = $generales[0];
        $adic = dbConnection::select(["usuarios.id_usuario" ,"medicos.estado", "medicos.domicilioConsultorio", "medicos.telEmergencias", "medicos.celEmergencias",
                "medicos.emailEmergencias", "medicos.facebook", "medicos.twitter", "medicos.horario_trabajo", "medicos.tiempo_consulta", "medicos.especialidad", "medicos.universidad"], 
            "medicos", 
            [["medicos.id_usuario", $_POST['personalId']]],
            [["usuarios", "medicos.id_usuario", "usuarios.id_usuario"]]
            );
            $infoDoctor['adicional'] = $adic[0];
        
        return json_encode($infoDoctor);
    }
    else
    {
        return 0;
    }
});

Route::POST('/ajaxAgR' /* Admin guarda recepcionista*/, function() {
    if($_POST['idEmpleado']!="")
    {
        if($_POST['pass']==''){
            dbConnection::update("usuarios",
                ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
                [$_POST['usuario'],$_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion']],
                [['usuarios.id_usuario', $_POST['idEmpleado']]]);
            dbConnection::update("recepcionistas",
                ['estado'],
                [$_POST['estado']],
                [['recepcionistas.id_usuario', $_POST['idEmpleado']]]);    
        }
        else
        {
            $cipher_pass = hash("sha256", $_POST['pass']);
            dbConnection::update("usuarios",
                ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
                [$_POST['usuario'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion']],
                [['usuarios.id_usuario', $_POST['idEmpleado']]]);
            dbConnection::update("recepcionistas",
                ['estado'],
                [$_POST['estado']],
                [['recepcionistas.id_usuario', $_POST['idEmpleado']]]);    
         return $_POST['idEmpleado'];
       }
    }
    else
    {
        $cipher_pass = hash("sha256", $_POST['pass']);
        dbConnection::insert("usuarios",
            ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
            [[$_POST['usuario'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], 
                $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion']]]
            );
        $idEmpleado = dbConnection::lastID();
        
        dbConnection::insert("recepcionistas", ["id_usuario","estado"], [[$idEmpleado,$_POST['estado']]]);
        return $idEmpleado;
    }
});

Route::POST('/ajaxAgD' /* Admin guarda Doctor*/, function() {
    $horario = "";
    if(isset($_POST['lunes']))
        $horario=$horario."l";
    if(isset($_POST['martes']))
        $horario=$horario."m";
    if(isset($_POST['miercoles']))
        $horario=$horario."x";
    if(isset($_POST['jueves']))
        $horario=$horario."j";
    if(isset($_POST['viernes']))
        $horario=$horario."v";
    if(isset($_POST['sabado']))
        $horario=$horario."s";
    if(isset($_POST['domingo']))
        $horario=$horario."d";
    $horario=$horario."(".$_POST['inicio']."-".$_POST['fin'].")";
    if($_POST['idEmpleado']!="")
    {
        
        if($_POST['pass']==''){
            dbConnection::update("usuarios",
                ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
                [$_POST['usuario'],$_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion']],
                [['usuarios.id_usuario', $_POST['idEmpleado']]]);
            
            dbConnection::update("medicos",
                ['domicilioConsultorio', 'estado', 'telEmergencias', 'celEmergencias', 'emailEmergencias', 'facebook', 'twitter', 'cedula', 'especialidad', 'universidad', 'horario_trabajo', "tiempo_consulta"],
                [$_POST['domPart'], $_POST['estado'], $_POST['telEme'], $_POST['celEmergencias'], $_POST['correoAux'], $_POST['face'], $_POST['twitter'], $_POST['cedula'], $_POST['Especialidad'], $_POST['universidad'], $horario, $_POST['tiempo']],
                [['medicos.id_usuario', $_POST['idEmpleado']]]);

        }
        else
        {
            $cipher_pass = hash("sha256", $_POST['pass']);
            dbConnection::update("usuarios",
                ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
                [$_POST['usuario'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion']],
                [['usuarios.id_usuario', $_POST['idEmpleado']]]);
             dbConnection::update("medicos",
                ['domicilioConsultorio','estado', 'telEmergencias', 'celEmergencias', 'emailEmergencias', 'facebook', 'twitter', 'cedula', 'especialidad', 'universidad', 'horario_trabajo', "tiempo_consulta"],
                [$_POST['domPart'], $_POST['estado'], $_POST['telEme'], $_POST['celEmergencias'], $_POST['correoAux'], $_POST['face'], $_POST['twitter'], $_POST['cedula'], $_POST['Especialidad'], $_POST['universidad'], $horario, $_POST['tiempo']],
                [['medicos.id_usuario', $_POST['idEmpleado']]]);    


        return $_POST['idEmpleado'];
        }
    }
    else
    {
        $cipher_pass = hash("sha256", $_POST['pass']);
        dbConnection::insert("usuarios",
            ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
            [[$_POST['usuario'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero'], $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion']]]
            );
        $idEmpleado = dbConnection::lastID();
       
        dbConnection::insert("medicos",
                ['id_usuario','domicilioConsultorio', 'estado','telEmergencias', 'celEmergencias', 'emailEmergencias', 'facebook', 'twitter', 'cedula', 'especialidad', 'universidad', 'horario_trabajo', "tiempo_consulta"],
                [[$idEmpleado, $_POST['domPart'],$_POST['estado'],$_POST['telEme'], $_POST['celEmergencias'], $_POST['correoAux'], $_POST['face'], $_POST['twitter'], $_POST['cedula'], $_POST['Especialidad'], $_POST['universidad'], $horario, $_POST['tiempo']]],
                [['medicos.id_usuario', $_POST['idEmpleado']]]);       
        
        return $idEmpleado;
    }
});

Route::POST('/ajaxRgP' /* Recepcionista guarda Paciente*/, function() {
    if($_POST['idPaciente']!=-1)
    {
        if($_POST['pass']==''){
            
            dbConnection::update("usuarios",
                ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                [$_POST['usuario'],$_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero']!="-1"?$_POST['genero']:null, $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion'], $_POST['ciudad'], $_POST['estado']],
                [['usuarios.id_usuario', $_POST['idPaciente']]]
            );
            if($_POST['idResponsable'] != "" && isset($_POST['miResponsable']))
            {
                if($_POST['responsablePass']=="")
                {
                    dbConnection::update("usuarios",
                        ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion'],
                        [$_POST['responsableUsuario'],$_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['ciudad'], $_POST['estado']],
                        [['usuarios.id_usuario', $_POST['idResponsable']]]
                    );
                }
                else
                {
                    $cipher_pass = hash("sha256", $_POST['responsablePass']);
                    dbConnection::update("usuarios",
                        ['usuario', "pass", 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [$_POST['responsableUsuario'], $cipher_pass, $_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']],
                        [['usuarios.id_usuario', $_POST['idResponsable']]]
                    );
                }
            }
            elseif($_POST['idResponsable'] == "" && isset($_POST['miResponsable']))
            {
                if($_POST['responsablePass']=="")
                {
                    dbConnection::insert("usuarios",
                        ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [[$_POST['responsableUsuario'],$_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']]]
                    );
                }
                else
                {
                    
                    $cipher_pass = hash("sha256", $_POST['responsablePass']);
                    $algo = dbConnection::insert("usuarios",
                        ['usuario', "pass", 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [[$_POST['responsableUsuario'], $cipher_pass, $_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero'], $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']]]
                    );
                }
                $id = dbConnection::lastID();
                dbConnection::insert("encargados", ["id_usuario", "id_paciente"], [[$id, $_POST['idPaciente']]]);
            }
            elseif($_POST['idResponsable'] != "" && !isset($_POST['miResponsable']))
            {
                dbConnection::delete("usuarios", [["id_usuario", $_POST['idResponsable']]]);
                dbConnection::delete("encargados", [["id_usuario", $_POST['idResponsable']]]);
            }

        }
        else
        {
            $cipher_pass = hash("sha256", $_POST['pass']);
            dbConnection::update("usuarios",
                ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                [$_POST['usuario'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero']!="-1"?$_POST['genero']:null, $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion'], $_POST['ciudad'], $_POST['estado']],
                [['usuarios.id_usuario', $_POST['idPaciente']]]);
            if($_POST['idResponsable'] != "" && isset($_POST['miResponsable']))
            {
                if($_POST['responsablePass']=="")
                {
                    var_dump($_POST['idResponsable']);
                    dbConnection::update("usuarios",
                        ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [$_POST['responsableUsuario'],$_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']],
                        [['usuarios.id_usuario', $_POST['idResponsable']]]);
                }
                else
                {
                    $cipher_pass = hash("sha256", $_POST['responsablePass']);
                    dbConnection::update("usuarios",
                        ['usuario', "pass", 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [$_POST['responsableUsuario'], $cipher_pass, $_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']],
                        [['usuarios.id_usuario', $_POST['idResponsable']]]
                    );
                }
            }
            elseif($_POST['idResponsable'] == "" && isset($_POST['miResponsable']))
            {
                if($_POST['responsablePass']=="")
                {
                    dbConnection::insert("usuarios",
                        ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [[$_POST['responsableUsuario'],$_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']]]
                    );
                }
                else
                {
                    
                    $cipher_pass = hash("sha256", $_POST['responsablePass']);
                    $algo = dbConnection::insert("usuarios",
                        ['usuario', "pass", 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                        [[$_POST['responsableUsuario'], $cipher_pass, $_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']]]
                    );
                }
                $id = dbConnection::lastID();
                dbConnection::insert("encargados", ["id_usuario", "id_paciente"], [[$id, $_POST['idPaciente']]]);
            }
            elseif($_POST['idResponsable'] != "" && !isset($_POST['miResponsable']))
            {
                dbConnection::delete("usuarios", [["id_usuario", $_POST['idResponsable']]]);
                dbConnection::delete("encargados", [["id_usuario", $_POST['idResponsable']]]);
            }
        }
        return $_POST['idPaciente'];
    }
    else
    {
        $cipher_pass = hash("sha256", $_POST['pass']);
        dbConnection::insert("usuarios",
            ['usuario', 'pass', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
            [[$_POST['usuario'], $cipher_pass, $_POST['nombre'], $_POST['email'], $_POST['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['domicilio'], $_POST['codigoPostal']==""?null:$_POST['codigoPostal'], $_POST['domTel'], $_POST['ofTel'], $_POST['genero']!="-1"?$_POST['genero']:null, $_POST['seguroSocial'], $_POST['fechaNacimiento']==""?null: $_POST['fechaNacimiento'], $_POST['ocupacion'], $_POST['ciudad'], $_POST['estado']]]
            );
        $idPaciente = dbConnection::lastID();
        dbConnection::insert("pacientes", ["id_usuario"], [[$idPaciente]]);
        if($_POST['idResponsable'] == "" && isset($_POST['miResponsable']))
        {
            if($_POST['responsablePass']=="")
            {
                dbConnection::insert("usuarios",
                    ['usuario', 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                    [[$_POST['responsableUsuario'],$_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']]]
                );
            }
            else
            {
                
                $cipher_pass = hash("sha256", $_POST['responsablePass']);
                $algo = dbConnection::insert("usuarios",
                    ['usuario', "pass", 'nombre', 'email', 'apellidoPaterno', 'apellidoMaterno', 'Domicilio', 'codigoPostal', 'telefonoDomiciliar', 'telefonoCelular', 'genero', 'noSeguroSocial', 'fechaNacimiento', 'Ocupacion', 'ciudad', 'estado'],
                    [[$_POST['responsableUsuario'], $cipher_pass, $_POST['responsableNombre'], $_POST['responsableEmail'], $_POST['responsableApellidoPaterno'], $_POST['responsableApellidoMaterno'], $_POST['responsableDomicilio'], $_POST['responsableCodigoPostal']==""?null:$_POST['responsableCodigoPostal'], $_POST['responsableDomTel'], $_POST['responsableOfTel'], $_POST['responsableGenero']!="-1"?$_POST['responsableGenero']:null, $_POST['responsableSeguroSocial'], $_POST['responsableFechaNacimiento']==""?null: $_POST['responsableFechaNacimiento'], $_POST['responsableOcupacion'], $_POST['responsableCiudad'], $_POST['responsableEstado']]]
                );
            }
            $id = dbConnection::lastID();
            dbConnection::insert("encargados", ["id_usuario", "id_paciente"], [[$id, $idPaciente]]);
        }
        return $idPaciente;
    }
});


Route::get("/dashboard/medicines", function() {
    if(Type::isPatient()||Type::isInCharge())
    {
        return view('patient/medicines');
    }
    else
    {
        return redirect('/dashboard');
    }
});


Route::POST("/android/logIn", function(){
    if(isset($_POST['user']) && isset($_POST['pass']))
    {
        $key = logData::logInAndroid($_POST['user'], $_POST['pass']);
        if($key !== false)
        {
            $type = logData::getType();
            $datos = array(
                "key" => $key,
                "type" => $type
            );
            $check = false;
            $id = logData::getData("id_usuario");
            if(Type::isMedic())
            {
                $check = dbConnection::select(["estado"], "medicos", [["id_usuario", $id]])[0]['estado']==1?true:false;
            }
            elseif(Type::isPatient())
            {
                $check = dbConnection::select(["estado"], "pacientes", [["id_usuario", $id]])[0]['estado']==1?true:false;
            }
            elseif(Type::isInCharge())
            {
                $check = count(dbConnection::select(["id_paciente"], "encargados", [["id_paciente", 0, ">"]]))>0?true:false;
                if($check)
                {
                    $id = dbConnection::select(["*"], "encargados", [['id_usuario', $id]])[0]['id_paciente'];
                    $check = dbConnection::select(["estado"], "pacientes", [["id_usuario", $id]])[0]['estado']==1?true:false;
                }
            }
            if($check)
                echo json_encode($datos);
            else
                echo json_encode(array("error"=>"type"));
        }
        else
            echo json_encode(array("error"=>"data"));
    }
    else
        echo json_encode(array("error"=>"post"));
});




Route::POST("/android/retreiveData", function(){
    if(isset($_POST['type']) && isset($_POST['key']))
    {
        if($_POST['type'] == "medicos")
        {
            $user = dbConnection::select(["id_usuario"], "usuarios", [["sessionKey", $_POST['key']]]);
            $user = $user[0]["id_usuario"];
	    $dates = dbConnection::RAW("SELECT citas.fecha_hora, usuarios.id_usuario, tipocita.nombre as tipo 
		FROM citas 
		INNER JOIN usuarios ON usuarios.id_usuario = citas.id_paciente
		INNER JOIN tipocita ON citas.tipo = tipocita.id
                WHERE citas.fecha_hora > now()
		AND id_medico = '$user'");
	    $retornar = array();
            $retornar["citas"] = $dates;
            echo json_encode($retornar);

        }
        else if($_POST['type'] == "pacientes")
        {
            $user = dbConnection::select(["id_usuario"], "usuarios", [["sessionKey", $_POST['key']]]);
            $user = $user[0]["id_usuario"];
            $meds = dbConnection::RAW("
                SELECT medicamentos.nombre, tratamiento.inicio, tratamiento.cada, tratamiento.durante, tratamiento.indicaciones 
                FROM tratamiento 
                INNER JOIN registro_clinico ON registro_clinico.id_registro = tratamiento.id_registro 
                INNER JOIN medicamentos ON medicamentos.id_medicamento = tratamiento.id_medicamento 
                WHERE tratamiento.inicio + INTERVAL tratamiento.durante HOUR > NOW()
                AND registro_clinico.id_paciente = '$user';
            ");
            $docs = dbConnection::select(["medicos.domicilioConsultorio", "telEmergencias", "celEmergencias", "facebook", "twitter", "especialidad", "usuarios.nombre", "usuarios.apellidoMaterno", "usuarios.apellidoPaterno"],
                            "citas",
                            [["citas.id_paciente", $user]],
                            [["medicos", "medicos.id_usuario", "citas.id_medico"], ["usuarios", "usuarios.id_usuario", "medicos.id_usuario"]],
                            "GROUP BY citas.id_medico");
            $dates = dbConnection::RAW("SELECT citas.fecha_hora, usuarios.nombre, apellidoMaterno, apellidoPaterno, tipocita.nombre as tipo 
		FROM citas 
		INNER JOIN usuarios ON usuarios.id_usuario = citas.id_medico
		INNER JOIN tipocita ON citas.tipo = tipocita.id
                WHERE citas.fecha_hora > now()
		AND id_paciente = '$user'");
            $retornar = array();
            $retornar["citas"] = $dates;
            $retornar["medicos"] = $docs;
            $retornar["medicamentos"] = $meds;
            echo json_encode($retornar);
        }
	else if($_POST['type'] == "encargado")
	{
	    $encargado = dbConnection::select(["id_usuario"], "usuarios", [["sessionKey", $_POST['key']]]);
            $encargado = $encargado [0]["id_usuario"];
	    $user = dbConnection::select(["id_paciente"], "encargados", [["id_usuario", $encargado]]);
	    $user = $user[0]["id_paciente"];
	    if($user!=-1)
	    {
                $meds = dbConnection::RAW("
                    SELECT medicamentos.nombre, tratamiento.inicio, tratamiento.cada, tratamiento.durante, tratamiento.indicaciones 
                    FROM tratamiento 
                    INNER JOIN registro_clinico ON registro_clinico.id_registro = tratamiento.id_registro 
                    INNER JOIN medicamentos ON medicamentos.id_medicamento = tratamiento.id_medicamento 
                    WHERE tratamiento.inicio + INTERVAL tratamiento.durante HOUR > NOW()
                    AND registro_clinico.id_paciente = '$user';
                ");
                $docs = dbConnection::select(["medicos.domicilioConsultorio", "telEmergencias", "celEmergencias", "facebook", "twitter", "especialidad", "usuarios.nombre", "usuarios.apellidoMaterno", "usuarios.apellidoPaterno"],
                                "citas",
                                [["citas.id_paciente", $user]],
                                [["medicos", "medicos.id_usuario", "citas.id_medico"], ["usuarios", "usuarios.id_usuario", "medicos.id_usuario"]],
                                "GROUP BY citas.id_medico");
                $dates = dbConnection::RAW("SELECT citas.fecha_hora, usuarios.nombre, apellidoMaterno, apellidoPaterno, tipocita.nombre as tipo 
		    FROM citas 
		    INNER JOIN usuarios ON usuarios.id_usuario = citas.id_medico
    		    INNER JOIN tipocita ON citas.tipo = tipocita.id
                    WHERE citas.fecha_hora > now()
    	            AND id_paciente = '$user'");
                $retornar = array();
                $retornar["citas"] = $dates;
                $retornar["medicos"] = $docs;
                $retornar["medicamentos"] = $meds;
                echo json_encode($retornar);
	    }
	    else
	    {
		$error["denegado"] = "eliminado";
		echo json_encode($error);
	    }
	}
    }
});

Route::POST("/android/userData", function(){
    if(isset($_POST['type']) && isset($_POST['key']))
    {
        if($_POST['type'] == "medicos")
        {
	    $id = $_POST['id'];
	    $data = dbConnection::RAW("
		SELECT usuarios.usuario, usuarios.nombre, usuarios.apellidoPaterno, usuarios.apellidoMaterno, diagnostico.enfermedad, diagnostico.estado, diagnostico.notas
		FROM usuarios
		INNER JOIN registro_clinico ON usuarios.id_usuario = registro_clinico.id_paciente
		INNER JOIN diagnostico ON diagnostico.id_diagnostico = registro_clinico.id_diagnostico
		WHERE id_usuario = ".$id."
		AND registro_clinico.fecha_hora = (SELECT MAX(registro_clinico.fecha_hora )
	             FROM registro_clinico 
	             WHERE registro_clinico.id_paciente = ".$id."
		     )
		AND registro_clinico.fecha_hora<now();");
	    if(isset($data[0]))
	        echo json_encode($data[0]);
	    else
                echo "{}";

        }
    }
});

Route::POST("/ajaxCU" /*Check User*/, function(){
    if(count(dbConnection::select(["*"], "usuarios", [["usuario", $_POST['user']]]))>0)
        echo json_encode(["ok"=>false]);
    else
        echo json_encode(["ok"=>true]);
});

Route::POST("/ajaxCE" /*Check email*/, function(){
    if(count(dbConnection::select(["*"], "usuarios", [["email", $_POST['email']]]))>0)
        echo json_encode(["ok"=>false]);
    else
        echo json_encode(["ok"=>true]);
});