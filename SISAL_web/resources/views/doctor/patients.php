<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $pacientes = dbConnection::select(["citas.id_paciente", "usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno", "MAX(citas.fecha_hora) as ultima"],
        "citas",
        [["citas.id_medico", logData::getData("id_usuario")]],
        [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]],
        "GROUP BY citas.id_paciente");
    $existeGet = false;
    if(isset($_GET['id']))
    {
        foreach($pacientes as $p)
        {
            if($p['id_paciente']==$_GET['id'])
            {
                $existeGet = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Doctor</title>

      <!-- Bootstrap Core CSS -->
    <link href="../../dataSource/css/templates/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../dataSource/css/templates/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dataSource/css/templates/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../dataSource/css/templates/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="../../dataSource/css/templates/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../dataSource/css/templates/dataTables.responsive.css" rel="stylesheet">

    <!-- FontsAwsome CSS -->
    <link href="../../dataSource/css/templates/font-awesome.css" rel="stylesheet">
    <link rel='shortcut icon' href='../dataSource/img/favicon.png' type='image/x-icon'/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        label input[type="radio"] ~ i.fa.fa-circle-o{
            color: #c8c8c8;    display: inline;
        }
        label input[type="radio"] ~ i.fa.fa-dot-circle-o{
            display: none;
        }
        label input[type="radio"]:checked ~ i.fa.fa-circle-o{
            display: none;
        }
        label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
            color: #7AA3CC;    display: inline;
        }
        label:hover input[type="radio"] ~ i.fa {
        color: #7AA3CC;
        }
    </style>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/..">
                <IMG SRC="/dataSource/img/SISAL3.png" WIDTH=120 HEIGHT=37 ALT="SISAL">  
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> Usuario <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../dashboard/userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                        </li>
                        <li><a href="/logOut"><i class="fa fa-gear fa-fw"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="../dashboard"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i>Proximas Citas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../dashboard/dates/?type=surgery">Quirurgicas</a>
                                </li>
                                <li>
                                    <a href="../dashboard/dates/?type=clinic">Clinicas</a>
                                </li>
                                <li>
                                    <a href="../dashboard/dates/?type=all">Todas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="../dashboard/registerData"><i class="fa fa-edit fa-fw"></i> Registro medico</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Pacientes</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Pacientes</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

                <!-- LISTA DE PACIENTES -->
                <div class="col-lg-12" >
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Usuario</th>
                                        <th>Paciente</th>
                                        <th>Última consulta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($pacientes as $p): ?>
                                    <tr class="odd gradeX">
                                        <td><label class="btn active">
                                            <input type="radio" name="paciente" value="<?php echo $p['id_paciente']; ?>"id="<?php echo "radio".$p['id_paciente']?>" style="display:none"/>
                                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>
                                        </label></td>
                                        <td><?php echo $p['usuario']; ?></td>
                                        <td><?php echo $p['nombre'] . " " . $p['apellidoPaterno'] . " " . $p['apellidoMaterno']; ?></td>
                                        <td><?php echo date("d-m-Y H:i", strtotime($p['ultima'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <?php if(isset($_GET['id'])): ?>
                    <div class="col-lg-12" name="toda_info" id="toda_info">
                <?php else: ?>
                    <div class="col-lg-12" name="toda_info" id="toda_info" style="visibility: hidden; display:none;">
                <?php endif; ?>
                        <div class="panel panel-default"aria-multiselectable="true">
                            <div class="panel-heading">
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-warning" onclick="edicion(); return false;" type="submit" id="editar">Editar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-success" type="submit" id="aceptar" onclick="aceptacion(); return false;" style="display:none;">Aceptar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-danger" type="submit" id="cancelar" onclick="cancelacion(); return false;" style="display:none;">Cancelar</button></span>
                                <span><h2 id="nombre_completo" name="nombre_completo"></h2></span>
                            </div>
                        
                            <div id="tablist">
                            <form name="formulario" id="formulario">
                            <input type="text" name="idPaciente" id="idPaciente" hidden/>
                                <!-- Desplegable información Personal--> 
                                <br>
                                <div>
                                    <a href="javascript:myToggler('pInf');" data-toggle="collapse" role ="tab" data-target="#pInf" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:100%;">
                                        <h4>Información personal</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="pInf" >
                                        <table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                        <tr>
                                        <td>
                                        <b>Nombre:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" style="height: 30px; width: 100%;"  disabled/>
                                        </div>   
                                        </td>
                                        <td>
                                        <b>Apellido Paterno:</b>                              
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="apellidoPaterno" name="apellidoPaterno" style="height: 30px; width: 100%;" placeholder="Apellido Paterno"  disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>Apellido Materno:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="apellidoMaterno" name="apellidoMaterno" style="height: 30px; width: 100%;" placeholder="Apellido Materno"  disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <b>Domicilio:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="Domicilio"name="Domicilio" placeholder="Domicilio" style="height: 30px; width: 100%;" disabled/>
                                        </div>
                                        </td>
                                        </td>
                                        <tr>
                                        <td>
                                        <b>Código postal:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Código Postal" id="codigoPostal" name="codigoPostal" style="height: 30px; width: 100%;"  disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <br>Teléfono:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" style="height: 30px; width: 100%;" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>Celular:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono Celular" id="celTel" name="celTel" style="height: 30px; width: 100%;"  disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <b>Correo:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Correo Electrónico" id="email" name="email" style="height: 30px; width: 100%;" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>Sexo:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="genero" placeholder="genero" id="genero" name="genero" style="height: 30px; width: 100%;" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <b>No. Seguridad social:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="No. de Seguridad social" id="seguroSocial" name="seguroSocial" style="height: 30px; width: 100%;" disabled/>
                                        </div>
                                       </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <b>Fecha de nacimiento:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="fechaNacimiento" name="fechaNacimiento" style="height: 30px; width: 100%;"  disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <b>Ocupación:</b>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ocupación" id="ocupacion" name="ocupacion"  style="height: 30px; width: 100%;"  disabled/>
                                        </div>
                                        </td>                                        
                                        </tr>
                                        <tr>                                        
                                        <td>
                                        <?php
                                            $diff = abs(strtotime(date('Y-m-d')) - strtotime(logData::getData('fechaNacimiento')));
                                            $years = floor($diff / (365*60*60*24));
                                        ?>
                                        <b>Edad:</b>
                                        
                                            <label  id="edad" style="height: 30px; width: 100%;" ><?php echo ($years); ?> años de edad.</label>
                                       
                                        </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                                <!-- Desplegable Antecedentes personales--> 
                                <?php $sangres = dbConnection::select(["tipo", "id_sangre"], "tipo_sangre"); ?>
                                <br>
                                <div>
                                    <a href="javascript:myToggler('aPer');" role ="tab" data-toggle="collapse" data-target="#aPer" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:100%;">
                                        <h4>Antecedentes personales</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="aPer">
                                        <table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Tipo de sangre</label>
                                            <select class="form-control" name="sangre" id="sangre" disabled>
                                                <?php foreach($sangres as $s):?>
                                                    <option value="<?php echo $s['id_sangre'];?>"> <?php echo $s['tipo'];?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Tabaquismo</label>
                                            <select class="form-control" name="tabaquismoCantidad" id="tabaquismoCantidad" disabled>
                                                <option value="Nunca">Nunca</option>
                                                <option value="Casual">Casual</option>
                                                <option value="Moderado">Moderado</option>
                                                <option value="Intenso">Intenso</option>
                                                <option value="En remisión">En remisión</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Alcoholismo</label>
                                            <select class="form-control" name="alcoholismoCantidad" id="alcoholismoCantidad" disabled>
                                                <option>Nunca</option>
                                                <option>Casual</option>
                                                <option>Moderado</option>
                                                <option>Intenso</option>
                                                <option>En remisión</option>
                                                <option>Otro</option>
                                            </select>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes hereditarios</label>
                                            <textarea class="form-control" name="antecedentesHereditarios" id="antecedentesHereditarios" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes patológicos</label>
                                            <textarea class="form-control" name="antecedentesPatologicos" id="antecedentesPatologicos" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes no patológicos</label>
                                            <textarea class="form-control" name="antecedentesNoPatologicos" id="antecedentesNoPatologicos" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- Desplegable Interrogatorio de antecedentes médicos--> 
                                <br>
                                <div>
                                    <a href="javascript:myToggler('int');" role ="tab" data-toggle="collapse" data-target="#int" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:100%;">
                                        <h4>Interrogatorio</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="int"  >
                                        <table width="100%" class="table table-striped  table-hover" id="dataTables-example">   
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes cardiovasculares</label>
                                            <textarea class="form-control" name="antecedentesCardio" id="antecedentesCardio" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes digestivos</label>
                                            <textarea class="form-control" name="antecedentesDigest" id="antecedentesDigest" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes endocrinos</label>
                                            <textarea class="form-control" name="antecedentesEndocr" id="antecedentesEndocr" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes hemolinfatico</label>
                                            <textarea class="form-control" name="antecedentesHemo" id="antecedentesHemo" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de Músculo-Esquelético</label>
                                            <textarea class="form-control" name="antecedentesMusc" id="antecedentesMusc" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de Piel y anexos</label>
                                            <textarea class="form-control" name="antecedentesPiel" id="antecedentesPiel" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de aparato reproductor</label>
                                            <textarea class="form-control" name="antecedentesRepr" id="antecedentesRepr" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de aparato respiratorio</label>
                                            <textarea class="form-control" name="antecedentesResp" id="antecedentesResp" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de sistema nervioso</label>
                                            <textarea class="form-control" name="antecedentesNerv" id="antecedentesNerv" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de sistemas generales</label>
                                            <textarea class="form-control" name="antecedentesGene" id="antecedentesGene" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Antecedentes de aparato urinario</label>
                                            <textarea class="form-control" name="antecedentesUri" id="antecedentesUri" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Desplegable Estilo de vida--> 
                                <br>
                                <div>
                                    <a href="javascript:myToggler('eVid');" role ="tab" data-toggle="collapse" data-target="#eVid" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:100%;">
                                        <h4>Estilo de vida</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="eVid"  >
                                        <table width="100%" class="table table-striped  table-hover" id="dataTables-example">   
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="ejercicio" id="ejercicio" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="ejercicio" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Realiza ejercicio?
                                                </label>
                                                <label for="ejercicio" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                            
                                                <br>
                                                <br>
                                                <label class="btn"><b>Veces a la semana:&nbsp</b></label><input type="number" id="ejercicioVecesSemana" name="ejercicioVecesSemana" class="btn btn-default" value="0" min="0" max="7" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <div class="btn-group">
                                                <label class="btn"><b>Horas de sueño diarias:&nbsp</b></label><input type="number" class="btn btn-default" name="horasSuenio" id="horasSuenio" value="0" min="0" max="20" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="desayuna" id="desayuna" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="desayuna" class="btn btn-default active" id="checkbox" disabled>
                                                    <b>¿Desayuna?</b>
                                                </label>
                                                <label for="desayuna" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                
                                                <br>
                                                <br>
                                                <label class="btn"><b>Comidas al día:&nbsp</b></label> <input class="btn btn-default" type="number" name="comidasDia" id="comidasDia" value="0" min="0" max="10" disabled/>

                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="cafe" id="cafe" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                
                                                <label for="cafe" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Toma Café?
                                                </label>
                                                <label for="cafe" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <br>
                                                <br>
                                                
                                                <label class="btn"><b>Tazas al día:&nbsp</b></label><input class="btn btn-default" type="number" id="cafeAlDia" name="cafeAlDia" value="0" min="0" max="50" disabled/>    
                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="refresco" id="refresco" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                               
                                                <label for="refresco" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Toma refresco?
                                                </label>
                                                 <label for="refresco" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <br>
                                                <br>
                                                <label class="btn"><b>Vasos al día:&nbsp</b></label>
                                                <input class="btn btn-default" type="number" id="refrescoAlDia" name="refrescoAlDia" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="dieta" id="dieta" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                            <label for="dieta" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Sigue alguna dieta?
                                                </label>
                                                <label for="dieta" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label> 
                                            </div>
                                            <br>
                                            <label class="btn"><b>Información sobre la dieta:&nbsp</b></label>
                                            <textarea type="text" placeholder="Información sobre la dieta" class="form-control" name="dietaInfo" id="dietaInfo" disabled></textarea>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="alcohol" id="alcohol" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="alcohol" class="btn btn-default active" name="checkAlcolico2" id="checkbox" disabled>
                                                    ¿Consume Alcohol?
                                                </label>
                                                <label for="alcohol" class="btn btn-default" name="checkAlcolico1" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                
                                                <br><br>
                                                <label class="btn"><b>Edad a la que comenzó a beber:&nbsp</b></label><input class="btn btn-default" type="number" name="alcoholEdad" id="alcoholEdad" value="0" min="0" max="80" disabled/>
                                                <br>
                                                <br>
                                                <label class="btn"><b>Vasos de bebidas alcoholicas al día:&nbsp</b></label><input class="btn btn-default" type="number" name="alcoholAlDia" id="alcoholAlDia" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="exAlcoholico" id="exAlcoholico" autocomplete="off"/>
                                            <div class="btn-group">
                                                <label for="exAlcoholico" class="btn btn-default active" name="checkExAlcholico2" id="checkbox" disabled>
                                                    ¿Ex-alcóholico?
                                                </label>
                                                <label for="exAlcoholico" class="btn btn-default" id="checkbox" name="checkExAlcholico1"disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <br><br>
                                                <label class="btn"><b>Edad a la que dejó de beber:&nbsp</b></label><input class="btn btn-default" type="number" name="exAlcoholicoEdad" id="exAlcoholicoEdad" value="0" min="0" max="80" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="fuma" id="fuma" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="fuma" class="btn btn-default active" id="checkbox" name="checkfuma2" disabled>
                                                    ¿Fuma?
                                                </label>
                                                <label for="fuma" class="btn btn-default" id="checkbox" name="checkfuma1" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <br>
                                                <label class="btn"><b>Edad a la que comenzó a fumar:&nbsp</b></label><input class="btn btn-default" name="fumaEdad" id="fumaEdad" type="number" value="0" min="0" max="80" disabled/>
                                                <label class="btn"><b>Cigarrillos al día:&nbsp</b></label><input class="btn btn-default" name="fumaAlDia" id="fumaAlDia" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="exFumador" id="exFumador" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="exFumador" class="btn btn-default active" id="checkbox" name="checkExFuma2" disabled>
                                                    ¿Ex-fumador?
                                                </label>
                                                <label for="exFumador" class="btn btn-default" id="checkbox" name="checkExFuma1" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <br>
                                                <label class="btn"><b>Edad a la que dejó de fumar:&nbsp</b></label><input class="btn btn-default" name="exFumadorEdad" id="exFumadorEdad" type="number" value="0" min="0" max="80" disabled/>
                                            </div>
                                            <input type="checkbox" name="fumadorPasivo" id="fumadorPasivo" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="fumadorPasivo" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Fumador-pasivo?
                                                </label>
                                                <label for="fumadorPasivo" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                
                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="droga" id="droga" autocomplete="off"/>
                                            <div class="btn-group">
                                                <label for="droga" class="btn btn-default active" id="checkbox" name="checkDroga2" disabled>
                                                    ¿Consume algun tipo de droga?
                                                </label>
                                                <label for="droga" class="btn btn-default" id="checkbox" name="checkDroga1" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                
                                                <br>
                                                <br>
                                                <label class="btn"><b>Edad a la que comenzó a consumir:&nbsp</b></label><input class="btn btn-default" name="drogaEdad" id="drogaEdad" type="number" value="0" min="0" max="80" disabled/>
                                            </div>
                                            <input type="checkbox" name="drogaIntra" id="drogaIntra" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="drogaIntra" class="btn btn-default active" name="dogaIntraLabel2" id="checkbox" disabled>
                                                    ¿Droga intravenosa?
                                                </label>
                                                <label for="drogaIntra" class="btn btn-default" id="checkbox" name="dogaIntraLabel1" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                
                                            </div>
                                            <br>
                                            <br>
                                            <b>Información adicional:</b>
                                            <textarea type="text" placeholder="Anotación acerca de las drogas consumidas" class="form-control" name="drogaAnota" id="drogaAnota" disabled></textarea>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <input type="checkbox" name="exAdicto" id="exAdicto" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="exAdicto" class="btn btn-default active" name="checkExAdicto2" id="checkbox" disabled>
                                                    ¿Ex-adicto?
                                                </label>
                                                <label for="exAdicto" class="btn btn-default" id="checkbox" name="checkExAdicto1" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                
                                                <br>
                                                <br>
                                                <label class="btn"><b>Edad a la que dejó de consumir:&nbsp</b></label><input class="btn btn-default" name="exAdictoEdad" id="exAdictoEdad" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Desplegable Alergias--> 
                                <br>
                                <div>
                                    <a href="javascript:myToggler('aler');" role ="tab" data-toggle="collapse" data-target="#aler" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:100%;">
                                        <h4>Alergias</h2>
                                    </div>
                                    </a>
                                    <div class="panel-body collapse indent" id="aler"  >
                                        <div class="form-group">
                                            <b>Información acerca de alergias.</b>
                                            <textarea class="form-control" name="alergias" id="alergias" placeholder="Alergias tanto a medicamentos como a materiales o alimentos" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!--//Form informacion paciente-->


                                <form name="InformacionCita" method="POST" action="/recetamedica">
                                <!-- Desplegable Citas--> 
                                <br>
                                <div>
                                    <input type="text" value="<?php echo csrf_token(); ?>" name="_token" hidden/>
                                    <a href="#citas" role ="tab" data-toggle="collapse" data-target="#citas" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:100%;">
                                        <h4>Expediente clinico</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="citas"  >
                                     <table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                     <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Medico: </label>
                                            <select class="form-control" name="medico" id="medico">
                                            </select>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="form-group">
                                            <label>Fecha de cita:</label>
                                            <select class="form-control" name="fechaCita" id="fechaCita">
                                            </select>
                                        </div>
                                        </td>
                                       </tr>
                                       </table> 
                                            <!-- Desplegable Contenido Cita--> 
                                            <div id="contenidoCita">
                                                <a href="#pCit" data-toggle="collapse" role ="tab" data-target="#pCit" data-parent="#tablist">
                                                 <div class="btn btn-primary" style="width:40%;">
                                                    <h4>Datos de la cita</h2>
                                                 </div>
                                                </a>                                        
                                                <div class="panel-body collapse indent" id="pCit" >
                                                    <label><h3><b>Diagnóstico:</b></h3></label><br>
                                                    <div class="form-group">
                                                        <h5><b>Enfermedad:</b></h5>
                                                        <input class="form-control" type="text" placeholder="CEnfermedad" id="CEnfermedad" name="CEnfermedad" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5><b>Estado:</b></h5>
                                                        <input class="form-control" type="text" placeholder="CEstado" id="CEstado" name="CEstado" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5><b>Notas:</b></h5>
                                                        <textarea type="text" placeholder="Notas:" class="form-control" id="CNotas" name="CNotas" disabled></textarea>
                                                    </div>
                                                    <label><h3><b>Interrogatorio:</b></h3></label><br>
                                                    <div class="form-group">
                                                        <h5><b>Motivos:</b></h5>
                                                        <textarea type="text" placeholder="Motivos de consulta:" class="form-control" id="CMotivos" name="CMotivos" disabled></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5><b>Sintomas:</b></h5>
                                                        <textarea type="text" placeholder="Síntomas: " class="form-control" id="CSintomas" name="CSintomas" disabled></textarea>
                                                    </div>
                                                    <label><h3><b>Exploración:</b></h3></label><table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                                   <tr>
                                                   <td>
                                                   <div class="form-group">
                                                        <h5><b>Peso:</b></h5>
                                                        <input class="form-control" type="number" placeholder="CPeso" id="CPeso" name="CPeso" disabled/>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Talla:</b></h5>
                                                        <input class="form-control" type="number" placeholder="CTalla" id="CTalla" name="CTalla" disabled/>
                                                    </div>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Exploracion Fisica:</b></h5>
                                                        <textarea type="text" placeholder="Exploración Física: " class="form-control" id="CExploracion" name="CExploracion" disabled></textarea>                                                        
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Frecuencia Cardíaca:</b></h5>
                                                        <input class="form-control" type="number" placeholder="CFreCar" id="CFreCar" name="CFreCar" disabled/>
                                                    </div>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Presion Alta:</b></h5>
                                                        <input class="form-control" type="number" placeholder="CPresAlta" id="CPresAlta" name="CPresAlta" disabled/>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Presion Baja:</b></h5>
                                                        <input class="form-control" type="number" placeholder="CPresBaja" id="CPresBaja" name="CPresBaja" disabled/>
                                                    </div>
                                                    </td>
                                                    </tr>
                                                    <<tr>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Frecuencia Respiratoria:</b></h5>
                                                        <input class="form-control" type="number" placeholder="CFreRes" id="CFreRes" name="CFreRes" disabled/>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="form-group">
                                                        <h5><b>Temperatura:</b></h5>
                                                        <input class="form-control" type="text" placeholder="CTemp" id="CTemp" name="CTemp" disabled/>
                                                    </div>
                                                    </td>
                                                    </tr>
                                                    </table>
                                                    <label><h3><b>Notas Adicionales:</b></h3></label><br>
                                                    <div class="form-group">
                                                        <h5><b>Notas:</b></h5>
                                                        <textarea type="text" placeholder="Exploración Física: " class="form-control" id="CNA" name="CNA" disabled></textarea>                                                          
                                                    </div>
                                                    

                                                    <label><h3><b>Estudios:</b></h3></label><br>
                                                    <div class="form-group">
                                                        <h5><b>Orden:</b></h5>
                                                        <input class="form-control" type="text" placeholder="COrden" id="COrden" name="COrden" disabled/>
                                                    </div>
                                                    <label><h3><b>Tratamiento:</b></h3></label><br>
                                                    <div class="form-group">
                                                        <h5><b>Receta:</b></h5>
                                                        <input type="submit" class="btn btn-primary" id="createPDF" value="Generar PDF" style="width:20%;"/>
                                                    </div>
                                                </div>
                                                <!--//Panel-->
                                            </div>
                                            <!--//Desplegable-->
                                        </form>
                                        <!--//Form InformacionCita-->
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel -->
                    
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    <!-- jQuery -->
    <script src="../../dataSource/js/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../dataSource/js/templates/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../dataSource/js/templates/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dataSource/js/templates/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../dataSource/js/jquery/jquery.dataTables2.js"></script>
    <script src="../../dataSource/js/templates/dataTables.bootstrap.min.js"></script>
    <script src="../../dataSource/js/templates/dataTables.responsive.js"></script>

     
    <script>
    var json = 0;
    var id = 0;
    var idDoctor = 0;
    var idCita = 0;
    var csrfVal="<?php echo csrf_token(); ?>";
    $(document).ready(function() 
    {
        $("#createPDF").prop("disabled", false);
        $('#dataTables-example').DataTable({
            responsive: true,
            "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "40%", "targets": 2 }
            ],
            "order": [[ 3, "desc" ]]
        });
        
        
        } );
        <?php if($existeGet): ?>
            id= "<?php echo $_GET['id'];?>";
            $('#idPaciente').val(id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                }
            })
            $.post("/ajaxDP", { <?php //DP se refiere a Doctor-Patients ?>
                'patientId': id
            },
            function(data, status){
                json = JSON.parse(data);
                if(json != 0)
                {
                    $('#toda_info').show();
                    $('#toda_info').attr("style", "");
                    document.getElementById('toda_info').scrollIntoView();
                    $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                    recuperarInfo();
                    cancelacion();
                }
                
            });
            $.post("/ajaxDDdP", {
                'patientId': id
            },
            function(data, status){
                document.getElementById("medico").innerHTML = "";
                doctores = JSON.parse(data);
                $("#medico").html("");
                $("#fechaCita").html("");
                if(doctores.cantidad>0)
                {
                    for(var x = 0; x< doctores.cantidad; x++)
                    {
                        document.getElementById("medico").innerHTML = document.getElementById('medico').innerHTML + "<option value=\"" + doctores[x].id_medico + "\">" + doctores[x].nombre + " " + doctores[x].apellidoPaterno + " " + doctores[x].apellidoMaterno + "</option>"
                    }
                    document.getElementById("fechaCita").innerHTML="";
                    idDoctor = doctores[0].id_medico;
                    $('#contenidoCita').hide();
                    obtenerFechas();
                }
                
            });
            $('html, body').animate({
                scrollTop: $("#toda_info").offset().top
            }, 1000);
        <?php endif; ?>
            $('input[type=radio][name=paciente]').on("click", function() {
            cancelacion();
            $('#contenidoCita').hide();
            <?php foreach ($pacientes as $key => $p): ?>
                <?php if($key==0): ?>
                    if (this.value == <?php echo $p['id_paciente'];?>) {
                        id=$('input:radio[name=paciente]:checked').val();
                    }
                <?php else: ?>
                    else if (this.value == <?php echo $p['id_paciente'];?>) {
                        id=$('input:radio[name=paciente]:checked').val();
                    }
                <?php endif; ?>
            <?php endforeach; ?>
            $('#idPaciente').val(id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                }
            })
            $.post("/ajaxDP", { <?php //DP se refiere a Doctor-Patients ?>
                'patientId': id
            },
            function(data, status){
                json = JSON.parse(data);
                if(json != 0)
                {
                    $('#toda_info').show();
                    $('#toda_info').attr("style", "");
                    document.getElementById('toda_info').scrollIntoView();
                    $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                    recuperarInfo();
                    cancelacion();
                }
                
            });
            $.post("/ajaxDDdP", {
                'patientId': id
            },
            function(data, status){
                document.getElementById("medico").innerHTML = "";
                doctores = JSON.parse(data);
                $("#medico").html("");
                $("#fechaCita").html("");
                if(doctores.cantidad>0)
                {
                    for(var x = 0; x< doctores.cantidad; x++)
                    {
                        document.getElementById("medico").innerHTML = document.getElementById('medico').innerHTML + "<option value=\"" + doctores[x].id_medico + "\">" + doctores[x].usuario + " - " + doctores[x].nombre + " " + doctores[x].apellidoPaterno + " " + doctores[x].apellidoMaterno + "</option>"
                    }
                    document.getElementById("fechaCita").innerHTML="";
                    idDoctor = doctores[0].id_medico;
                    $('#contenidoCita').hide();
                    obtenerFechas();
                }
                
            });
        });

        

        function edicion()
        {
            $('#formulario :input').prop('disabled', false);
            $('#editar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
            $('#aceptar').prop('disabled', false);
            $('label[id="checkbox"]').attr('disabled', false);
            $('#editar').hide();
            $('#cancelar').show();
            $('#aceptar').show();

            if(document.getElementById('ejercicio').checked){
                $('#ejercicioVecesSemana').prop('disabled', false);
            }
            else
            {
                $('#ejercicioVecesSemana').prop('disabled', true);
            }
            if(document.getElementById('cafe').checked){
                $('#cafeAlDia').prop('disabled', false);    
            }
            else{ 
                $('#cafeAlDia').prop('disabled', true); 
            }
            if(document.getElementById('refresco').checked){
                $('#refrescoAlDia').prop('disabled', false);
            }
            else
            {
                $('#refrescoAlDia').prop('disabled', true);
            }
            
            if(document.getElementById('dieta').checked){
                $('#dietaInfo').prop('disabled', false);
            }
            else
            {
                $('#dietaInfo').prop('disabled', true);
            }
            if(document.getElementById('alcohol').checked){
                $('#alcoholEdad').prop('disabled', false);
                $('#alcoholAlDia').prop('disabled', false);
            }
            else
            {
                $('#alcoholEdad').prop('disabled', true);
                $('#alcoholAlDia').prop('disabled', true);
            }
            if(document.getElementById('exAlcoholico').checked){
                $('#exAlcoholicoEdad').prop('disabled', false);
            }
            else
            {
                $('#exAlcoholicoEdad').prop('disabled', true);
            }
            if(document.getElementById('fuma').checked){
                $('#fumaEdad').prop('disabled', false);
                $('#fumaAlDia').prop('disabled', false);
            }
            else
            {
                $('#fumaEdad').prop('disabled', true);
                $('#fumaAlDia').prop('disabled', true);
            }
            if(document.getElementById('exFumador').checked){
                $('#exFumadorEdad').prop('disabled', false);
            }
            else
            {
                $('#exFumadorEdad').prop('disabled', true);
            }
            if(document.getElementById('droga').checked){
                $('#drogaEdad').prop('disabled', false);
                $('#drogaIntra').prop('disabled', false);
                $('label[name=dogaIntraLabel1]').prop('disabled', false);
                $('label[name=dogaIntraLabel2]').prop('disabled', false);
                $('#drogaAnota').prop('disabled', false);
            }
            else
            {
                $('#drogaEdad').prop('disabled', true);
                $('#drogaIntra').prop('disabled', true);
                $('label[name=dogaIntraLabel1]').attr('disabled', true);
                $('label[name=dogaIntraLabel2]').attr('disabled', true);
                $('#drogaAnota').prop('disabled', true);
            }
            if(document.getElementById('exAdicto').checked){
                $('#exAdictoEdad').prop('disabled', false);
            }
            else
            {
                $('#exAdictoEdad').prop('disabled', true);
            }
            recuperarInfo();
        }
        function cancelacion()
        {
            if(json.generales)
            {
            recuperarInfo();
            }
            $('#formulario :input').prop('disabled', true);
            $('#editar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
            $('#aceptar').prop('disabled', false);
            $('label[id="checkbox"]').attr('disabled', true);
            $('#editar').show();
            $('#cancelar').hide();
            $('#aceptar').hide();
            $('#medico').attr("disabled", false);
            $('#fechaCita').attr("disabled", false);
                
        }

        $('#ejercicio').change(function() {
            if(document.getElementById('ejercicio').checked){
                $('#ejercicioVecesSemana').prop('disabled', false);
            }
            else
            {
                $('#ejercicioVecesSemana').prop('disabled', true);
                $('#ejercicioVecesSemana').val(0);
            }
        });

        $('#cafe').change(function() {
            if(document.getElementById('cafe').checked){
                $('#cafeAlDia').prop('disabled', false);
            }
            else
            {
                $('#cafeAlDia').prop('disabled', true);
                $('#cafeAlDia').val(0);
            }
        });

        $('#refresco').change(function() {
            if(document.getElementById('refresco').checked){
                $('#refrescoAlDia').prop('disabled', false);
            }
            else
            {
                $('#refrescoAlDia').prop('disabled', true);
                $('#refrescoAlDia').val(0);
            }
        });

        $('#dieta').change(function() {
            if(document.getElementById('dieta').checked){
                $('#dietaInfo').prop('disabled', false);
            }
            else
            {
                $('#dietaInfo').prop('disabled', true);
                $('#dietaInfo').val("");
            }
        });

        $('#alcohol').change(function() {
            if(document.getElementById('alcohol').checked){
                $('#alcoholEdad').prop('disabled', false);
                $('#alcoholAlDia').prop('disabled', false);
                $('#exAlcoholico').attr('disabled', true);
                $('label[name=checkExAlcholico1]').attr('disabled', true);
                $('label[name=checkExAlcholico2]').attr('disabled', true);
                document.getElementById('exAlcoholico').checked = false;
                $('#exAlcoholicoEdad').val(0);
                
            }
            else
            {
                $('#alcoholEdad').prop('disabled', true);
                $('#alcoholAlDia').prop('disabled', true);
                $('#exAlcoholico').prop('disabled', false);
                $('label[name=checkExAlcholico1]').attr('disabled', false);
                $('label[name=checkExAlcholico2]').attr('disabled', false);
                $('#alcoholEdad').val(0);
                $('#alcoholAlDia').val(0);
            }
        });

        $('#exAlcoholico').change(function() {
            if(document.getElementById('exAlcoholico').checked){
                $('#alcoholEdad').prop('disabled', true);
                $('#alcoholAlDia').prop('disabled', true);
                $('#alcohol').attr('disabled', true);
                $('label[name=checkAlcolico1]').attr('disabled', true);
                $('label[name=checkAlcolico2]').attr('disabled', true);
                $('#exAlcoholicoEdad').prop('disabled', false);
                document.getElementById('alcohol').checked = false;
                $('#alcoholEdad').val(0);
                $('#alcoholAlDia').val(0);
                
            }
            else
            {
                $('#alcoholEdad').prop('disabled', true);
                $('#alcoholAlDia').prop('disabled', true);
                $('#alcohol').attr('disabled', false);
                $('label[name=checkAlcolico1]').attr('disabled', false);
                $('label[name=checkAlcolico2]').attr('disabled', false);
                $('#exAlcoholicoEdad').prop('disabled', true);
                $('#exAlcoholicoEdad').val(0);
            }
        });


        $('#fuma').change(function() {
            if(document.getElementById('fuma').checked){
                $('#fumaEdad').prop('disabled', false);
                $('#fumaAlDia').prop('disabled', false);
                $('#exFumador').prop('disabled', true);
                $('label[name=checkExFuma1]').attr('disabled', true);
                $('label[name=checkExFuma2]').attr('disabled', true);
                document.getElementById('exFumador').checked = false;
                $('#exFumadorEdad').val(0);
                $('#exFumadorEdad').prop('disabled', true);
                
            }
            else
            {
                $('#fumaEdad').prop('disabled', true);
                $('#fumaAlDia').prop('disabled', true);
                $('#exFumador').prop('disabled', false);
                $('label[name=checkExFuma1]').attr('disabled', false);
                $('label[name=checkExFuma2]').attr('disabled', false);                
                $('#fumaEdad').val(0);
                $('#fumaAlDia').val(0);
            }
        });

        $('#exFumador').change(function() {
            if(document.getElementById('exFumador').checked){
                $('#fumaEdad').prop('disabled', true);
                $('#fumaAlDia').prop('disabled', true);
                $('#fuma').prop('disabled', true);
                $('label[name=checkfuma1]').attr('disabled', true);
                $('label[name=checkfuma2]').attr('disabled', true);
                $('#exFumadorEdad').prop('disabled', false);
                document.getElementById('fuma').checked = false;
                $('#fumaEdad').val(0);
                $('#fumaAlDia').val(0);
                
            }
            else
            {
                $('#fumaEdad').prop('disabled', true);
                $('#fumaAlDia').prop('disabled', true);
                $('#fuma').prop('disabled', false);
                $('label[name=checkfuma1]').attr('disabled', false);
                $('label[name=checkfuma2]').attr('disabled', false);
                $('#exFumadorEdad').prop('disabled', true);
                $('#exFumadorEdad').val(0);
            }
        });


        $('#droga').change(function() {
            if(document.getElementById('droga').checked){
                $('#drogaEdad').prop('disabled', false);
                $('#exAdicto').prop('disabled', true);
                $('label[name=checkExAdicto1]').attr('disabled', true);
                $('label[name=checkExAdicto2]').attr('disabled', true);
                document.getElementById('exFumador').checked = false;
                $('#exAdictoEdad').val(0);
                $('#exAdictoEdad').prop('disabled', true);
                $('#drogaAnota').attr('disabled', false);
                $('label[name=dogaIntraLabel1]').attr('disabled', false);
                $('label[name=dogaIntraLabel2]').attr('disabled', false);
                $('#drogaIntra').attr('disabled', false);
            }
            else
            {
                $('#drogaEdad').prop('disabled', true);
                $('#exAdicto').prop('disabled', false);
                $('label[name=checkExAdicto1]').attr('disabled', false);
                $('label[name=checkExAdicto2]').attr('disabled', false);                
                $('#drogaEdad').val(0);
                $('label[name=dogaIntraLabel1]').attr('disabled', true);
                $('label[name=dogaIntraLabel2]').attr('disabled', true);
                $('#drogaAnota').html("")
                $('#drogaAnota').attr('disabled', true);
                $('#drogaIntra').attr('disabled', true);
                document.getElementById('drogaIntra').checked = false;
            }
        });

        $('#exAdicto').change(function() {
            if(document.getElementById('exAdicto').checked){
                $('#drogaEdad').prop('disabled', true);
                $('#droga').prop('disabled', true);
                $('label[name=checkDroga1]').attr('disabled', true);
                $('label[name=checkDroga2]').attr('disabled', true);
                $('#exAdictoEdad').prop('disabled', false);
                document.getElementById('droga').checked = false;
                $('#drogaEdad').val(0);

                $('#drogaAnota').html("")
                $('#drogaAnota').attr('disabled', true);
                
                $('label[name=dogaIntraLabel1]').attr('disabled', true);
                $('label[name=dogaIntraLabel2]').attr('disabled', true);
                $('#drogaIntra').attr('disabled', true);
                document.getElementById('drogaIntra').checked = false;
            }
            else
            {
                $('#drogaEdad').prop('disabled', true);
                $('#droga').prop('disabled', false);
                $('label[name=checkDroga1]').attr('disabled', false);
                $('label[name=checkDroga2]').attr('disabled', false);
                $('#exAdictoEdad').prop('disabled', true);
                $('#exAdictoEdad').val(0);
                $('#drogaIntra').attr('disabled', true);
            }
        });

        function recuperarInfo()
        {
            $('#nombre').val(json.generales.nombre);
            $('#apellidoPaterno').val(json.generales.apellidoPaterno);
            $('#apellidoMaterno').val(json.generales.apellidoMaterno);
            $('#Domicilio').val(json.generales.Domicilio);
            $('#codigoPostal').val(json.generales.codigoPostal);
            $('#domTel').val(json.generales.telefonoDomiciliar);
            $('#celTel').val(json.generales.telefonoCelular);
            $('#email').val(json.generales.email);
            if(json.generales.genero=="Masculino")
            {
                $('#genero').val("Masculino");
            }
            else if("Femenino")
            {
                $('#genero').val("Femenino");
            }
            else
            {
                $('#genero').val("-1");
            }
            $('#seguroSocial').val(json.generales.noSeguroSocial);
            var fecha = new Date(json.generales.fechaNacimiento);
            $('#fechaNacimiento').val(json.generales.fechaNacimiento);
            var hoy = new Date();
            var edad = 0;
            if(fecha.getDate() > hoy.getDate() && fecha.getMonth() > hoy.getMonth())
            {
                edad = hoy.getFullYear() - fecha.getFullYear() + 1;
            }
            else
            {
                edad = hoy.getFullYear() - fecha.getFullYear();
            }
            $('#edad').html(edad);
            $('#ocupacion').val(json.generales.Ocupacion);
            if(json.sangre)
            {
                $('#sangre').val(json.sangre.id_sangre);
            }
            if(json.antecedentes)
            {
                $('#tabaquismoCantidad').val(json.antecedentes.tabaquismo);
                $('#alcoholismoCantidad').val(json.antecedentes.alcoholismo);
                $('#antecedentesHereditarios').val(json.antecedentes.antecedentesHereditarios);
                $('#antecedentesPatologicos').val(json.antecedentes.antecedentesPatologicos);
                $('#antecedentesNoPatologicos').val(json.antecedentes.antecedentesNoPatologicos);
                $('#alcoholismoCantidad').val(json.antecedentes.alcoholismo);
                $('#alcoholismoCantidad').val(json.antecedentes.alcoholismo);
            }
            else
            {
                $('#tabaquismoCantidad').val("");
                $('#alcoholismoCantidad').val("");
                $('#antecedentesHereditarios').val("");
                $('#antecedentesPatologicos').val("");
                $('#antecedentesNoPatologicos').val("");
                $('#alcoholismoCantidad').val("");
                $('#alcoholismoCantidad').val("");
            }
            if(json.interrogatorio)
            {
                $('#antecedentesCardio').val(json.interrogatorio.antecedentesCardio);
                $('#antecedentesDigest').val(json.interrogatorio.antecedentesDigesti);
                $('#antecedentesEndocr').val(json.interrogatorio.antecedentesEndo);
                $('#antecedentesHemo').val(json.interrogatorio.antecedentesHemoli);
                $('#antecedentesMusc').val(json.interrogatorio.antecedentesMuscu);
                $('#antecedentesPiel').val(json.interrogatorio.antecedentesPiel);
                $('#antecedentesRepr').val(json.interrogatorio.antecedentesReprod);
                $('#antecedentesResp').val(json.interrogatorio.antecedentesRespi);
                $('#antecedentesNerv').val(json.interrogatorio.antecedentesNerv);
                $('#antecedentesGene').val(json.interrogatorio.antecedentesGener);
                $('#antecedentesUri').val(json.interrogatorio.antecedentesUrina);
            }
            else
            {
                $('#antecedentesCardio').val("");
                $('#antecedentesDigest').val("");
                $('#antecedentesEndocr').val("");
                $('#antecedentesHemo').val("");
                $('#antecedentesMusc').val("");
                $('#antecedentesPiel').val("");
                $('#antecedentesRepr').val("");
                $('#antecedentesResp').val("");
                $('#antecedentesNerv').val("");
                $('#antecedentesGene').val("");
                $('#antecedentesUri').val("");
            }

            if(json.ejercicio)
            {
                document.getElementById('ejercicio').checked = true;
                $('#ejercicioVecesSemana').val(json.ejercicio.veces_semana);
            }
            else
            {
                document.getElementById('ejercicio').checked = false;
                $('#ejercicioVecesSemana').val(0);
            }
            if(json.suenio)
            {
                $('#horasSuenio').val(json.suenio.horasDiarias);
            }
            if(json.comidas){
                if(json.comidas.desayuno)
                {
                    document.getElementById('desayuna').checked = true;
                }
                else
                {
                    document.getElementById('desayuna').checked = false;
                }
                $('#comidasDia').val(json.comidas.comidasDiarias);
            }
            if(json.cafe)
            {
                document.getElementById('cafe').checked = true;
                $('#cafeAlDia').val(json.cafe.tazasDiarias);
            }
            else
            {
                document.getElementById('cafe').checked = false;
                $('#cafeAlDia').val(0);
            }
            if(json.refresco)
            {
                document.getElementById('refresco').checked = true;
                $('#refrescoAlDia').val(json.refresco.vasosDiarios);
            }
            else
            {
                document.getElementById('refresco').checked = false;
                $('#refrescoAlDia').val(0);
            }
            if(json.dietas)
            {
                document.getElementById('dieta').checked = true;
                $('#dietaInfo').html(json.dietas.informacionDieta);
            }
            else
            {
                document.getElementById('dieta').checked = false;
                $('#dietaInfo').html("");
            }
            if(json.alcoholico)
            {
                document.getElementById('alcohol').checked = true;
                $('#alcoholEdad').val(json.alcoholico.edad_inicio);
                $('#alcoholAlDia').val(json.alcoholico.vasos);
            }
            else
            {
                document.getElementById('alcohol').checked = false;
                $('#alcoholEdad').val(0);
                $('#alcoholAlDia').val(0);
            }
            if(json.ex_alcoholico)
            {
                document.getElementById('exAlcoholico').checked = true;
                $('#exAlcoholicoEdad').val(json.ex_alcoholico.edad_fin);
            }
            else
            {
                document.getElementById('exAlcoholico').checked = false;
                $('#exAlcoholicoEdad').val(0);
            }
            if(json.fumador)
            {
                document.getElementById('fuma').checked = true;
                $('#fumaEdad').val(json.fumador.edad_inicio);
                $('#fumaAlDia').val(json.fumador.ciggarrosDiarios);
            }
            else
            {
                document.getElementById('fuma').checked = false;
                $('#fumaEdad').val(0);
                $('#fumaAlDia').val(0);
            }
            if(json.ex_fumador)
            {
                document.getElementById('exFumador').checked = true;
                $('#fumaEdad').val(json.ex_fumador.edad_fin);
            }
            else
            {
                document.getElementById('exFumador').checked = false;
                $('#fumaEdad').val(0);
            }
            if(json.estiloVida)
            {
                if(json.estiloVida.fumadorPasivo!=0)
                {
                    document.getElementById('fumadorPasivo').checked = true;
                }
            }
            else
            {
                document.getElementById('fumadorPasivo').checked = false;
            }
            if(json.drogas)
            {
                document.getElementById('droga').checked = true;
                $('#drogaEdad').val(json.drogas.edad_inicio);
                if(json.drogas.intravenosa != 0)
                {
                    document.getElementById('drogaIntra').checked = true;
                }
                else
                {
                    document.getElementById('drogaIntra').checked = false;
                }
                $('#drogaAnota').html(json.drogas.detalles);
            }
            else
            {
                document.getElementById('droga').checked = false;
                $('#drogaEdad').val(0);
                document.getElementById('drogaIntra').checked = false;
                $('#drogaAnota').html("");
            }
            if(json.exAdicto)
            {
                document.getElementById('exAdicto').checked = true;
                $('#exAdictoEdad').val(json.exAdicto.edad_fin);
            }
            if(json.alergias)
            {
                $('#alergias').html(json.alergias.descripcion);
            }
            else
            {
                $('#alergias').html("");
            }
            if(document.getElementById('exAdicto').checked){
                $('#drogaEdad').prop('disabled', true);
                $('#droga').prop('disabled', true);
                $('label[name=checkDroga1]').attr('disabled', true);
                $('label[name=checkDroga2]').attr('disabled', true);
                $('#exAdictoEdad').prop('disabled', false);
                document.getElementById('droga').checked = false;
                $('#drogaEdad').val(0);

                $('#drogaAnota').html("")
                $('#drogaAnota').attr('disabled', true);
                
                $('label[name=dogaIntraLabel1]').attr('disabled', true);
                $('label[name=dogaIntraLabel2]').attr('disabled', true);
                $('#drogaIntra').attr('disabled', true);
                document.getElementById('drogaIntra').checked = false;
            }
            else
            {
                $('#drogaEdad').prop('disabled', false);
                $('#droga').prop('disabled', false);
                $('label[name=checkDroga1]').attr('disabled', false);
                $('label[name=checkDroga2]').attr('disabled', false);
                $('#exAdictoEdad').prop('disabled', true);
                $('#exAdictoEdad').val(0);
                $('#drogaIntra').attr('disabled', false);
            }

            if(document.getElementById('droga').checked){
                $('#drogaEdad').prop('disabled', false);
                $('#exAdicto').prop('disabled', true);
                $('label[name=checkExAdicto1]').attr('disabled', true);
                $('label[name=checkExAdicto2]').attr('disabled', true);
                document.getElementById('exFumador').checked = false;
                $('#exAdictoEdad').val(0);
                $('#exAdictoEdad').prop('disabled', true);
                $('#drogaAnota').attr('disabled', false);
                $('label[name=dogaIntraLabel1]').attr('disabled', false);
                $('label[name=dogaIntraLabel2]').attr('disabled', false);
                $('#drogaIntra').attr('disabled', false);
            }
            else
            {
                $('#drogaEdad').prop('disabled', true);
                $('#exAdicto').prop('disabled', false);
                $('label[name=checkExAdicto1]').attr('disabled', false);
                $('label[name=checkExAdicto2]').attr('disabled', false);                
                $('#drogaEdad').val(0);
                $('label[name=dogaIntraLabel1]').attr('disabled', true);
                $('label[name=dogaIntraLabel2]').attr('disabled', true);
                $('#drogaAnota').html("")
                $('#drogaAnota').attr('disabled', true);
                $('#drogaIntra').attr('disabled', true);
                document.getElementById('drogaIntra').checked = false;
            }

            if(document.getElementById('exFumador').checked){
                $('#fumaEdad').prop('disabled', true);
                $('#fumaAlDia').prop('disabled', true);
                $('#fuma').prop('disabled', true);
                $('label[name=checkfuma1]').attr('disabled', true);
                $('label[name=checkfuma2]').attr('disabled', true);
                $('#exFumadorEdad').prop('disabled', false);
                document.getElementById('fuma').checked = false;
                $('#fumaEdad').val(0);
                $('#fumaAlDia').val(0);
                
            }
            else
            {
                $('#fumaEdad').prop('disabled', false);
                $('#fumaAlDia').prop('disabled', false);
                $('#fuma').prop('disabled', false);
                $('label[name=checkfuma1]').attr('disabled', false);
                $('label[name=checkfuma2]').attr('disabled', false);
                $('#exFumadorEdad').prop('disabled', true);
                $('#exFumadorEdad').val(0);
            }

            if(document.getElementById('fuma').checked){
                $('#fumaEdad').prop('disabled', false);
                $('#fumaAlDia').prop('disabled', false);
                $('#exFumador').prop('disabled', true);
                $('label[name=checkExFuma1]').attr('disabled', true);
                $('label[name=checkExFuma2]').attr('disabled', true);
                document.getElementById('exFumador').checked = false;
                $('#exFumadorEdad').val(0);
                $('#exFumadorEdad').prop('disabled', true);
                
            }
            else
            {
                $('#fumaEdad').prop('disabled', true);
                $('#fumaAlDia').prop('disabled', true);
                $('#exFumador').prop('disabled', false);
                $('label[name=checkExFuma1]').attr('disabled', false);
                $('label[name=checkExFuma2]').attr('disabled', false);                
                $('#fumaEdad').val(0);
                $('#fumaAlDia').val(0);
            }

            if(document.getElementById('exAlcoholico').checked){
                $('#alcoholEdad').prop('disabled', true);
                $('#alcoholAlDia').prop('disabled', true);
                $('#alcohol').attr('disabled', true);
                $('label[name=checkAlcolico1]').attr('disabled', true);
                $('label[name=checkAlcolico2]').attr('disabled', true);
                $('#exAlcoholicoEdad').prop('disabled', false);
                document.getElementById('alcohol').checked = false;
                $('#alcoholEdad').val(0);
                $('#alcoholAlDia').val(0);
                
            }
            else
            {
                $('#alcoholEdad').prop('disabled', false);
                $('#alcoholAlDia').prop('disabled', false);
                $('#alcohol').attr('disabled', false);
                $('label[name=checkAlcolico1]').attr('disabled', false);
                $('label[name=checkAlcolico2]').attr('disabled', false);
                $('#exAlcoholicoEdad').prop('disabled', true);
                $('#exAlcoholicoEdad').val(0);
            }

            if(document.getElementById('alcohol').checked){
                $('#alcoholEdad').prop('disabled', false);
                $('#alcoholAlDia').prop('disabled', false);
                $('#exAlcoholico').attr('disabled', true);
                $('label[name=checkExAlcholico1]').attr('disabled', true);
                $('label[name=checkExAlcholico2]').attr('disabled', true);
                document.getElementById('exAlcoholico').checked = false;
                $('#exAlcoholicoEdad').val(0);
                
            }
            else
            {
                $('#alcoholEdad').prop('disabled', true);
                $('#alcoholAlDia').prop('disabled', true);
                $('#exAlcoholico').prop('disabled', false);
                $('label[name=checkExAlcholico1]').attr('disabled', false);
                $('label[name=checkExAlcholico2]').attr('disabled', false);
                $('#alcoholEdad').val(0);
                $('#alcoholAlDia').val(0);
            }

            if(document.getElementById('dieta').checked){
                $('#dietaInfo').prop('disabled', false);
            }
            else
            {
                $('#dietaInfo').prop('disabled', true);
                $('#dietaInfo').html("");
            }

            if(document.getElementById('refresco').checked){
                $('#refrescoAlDia').prop('disabled', false);
            }
            else
            {
                $('#refrescoAlDia').prop('disabled', true);
                $('#refrescoAlDia').val(0);
            }

            if(document.getElementById('ejercicio').checked){
                $('#ejercicioVecesSemana').prop('disabled', false);
            }
            else
            {
                $('#ejercicioVecesSemana').prop('disabled', true);
                $('#ejercicioVecesSemana').val(0);
            }
        }

        function obtenerFechas()
        {
            document.getElementById("fechaCita").innerHTML ="";
            $.post("/ajaxDCdDdP", {
                    'patientId': id,
                    'doctorId' : idDoctor
                },
                function(data, status){
                    citas = JSON.parse(data);
                    for(var x = 0; x< citas.cantidad; x++)
                    {
                        document.getElementById("fechaCita").innerHTML = document.getElementById('fechaCita').innerHTML + "<option value=\"" + citas[x].id_registro + "\">" + citas[x].fecha + "</option>"
                    }
                    idCita = citas[0].id_registro;
                    obtenerCita()
                });
                
        }

        $('#medico').on('change', function() {
            idDoctor = $('#medico').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                }
            })
            obtenerFechas();
        });

        function obtenerCita()
        {
            $.post("/ajaxDCdP", {
                    'registroId': idCita
                },
                function(data, status){
                    cita = JSON.parse(data);
                    $('#contenidoCita').show();
                    
                    $('#CEnfermedad').val(cita.diagnotico.enfermedad);
                    $('#CEstado').val(cita.diagnotico.estado);
                    document.getElementById("CNotas").innerHTML = cita.diagnotico.notas;
                    document.getElementById("CMotivos").innerHTML = cita.interrogatorio.motivoConsulta;
                    document.getElementById("CSintomas").innerHTML = cita.interrogatorio.sintomas;
                    $('#CSintomas').val(cita.interrogatorio.sintomas);
                    $('#CPeso').val(cita.exploracion.peso);
                    $('#CTalla').val(cita.exploracion.talla);
                    document.getElementById("CExploracion").innerHTML = cita.exploracion.exploracionFisica;
                    $('#CFreCar').val(cita.exploracion.frecuenciaCardiaca);
                    $('#CFreRes').val(cita.exploracion.frecuenciaRespiratoria);
                    $('#CPresAlta').val(cita.exploracion.presArterAlta);
                    $('#CPresBaja').val(cita.exploracion.presArterBaja);
                    $('#CTemp').val(cita.exploracion.temperatura);
                    document.getElementById("CNA").innerHTML = cita.notas_adicionales.notas;
                    $('#COrden').val(cita.estudios.orden); 
                    $('#CReceta').val(cita.tratamiento); 
                });
            
        }

        $('#fechaCita').on('change', function() {
            idCita = $('#fechaCita').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                }
            })
            obtenerCita();
        });

        function aceptacion()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                }
            })
            $.post("/ajaxDgP",
                $('#formulario').serialize()
            ,
            function(data, status){
                
            });
            $('#formulario :input').prop('disabled', true);
            $('#editar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
            $('#aceptar').prop('disabled', false);
            $('label[id="checkbox"]').attr('disabled', true);
            $('#editar').show();
            $('#cancelar').hide();
            $('#aceptar').hide();
            $('#medico').attr("disabled", false);
            $('#fechaCita').attr("disabled", false);
            location.reload(true);
        }

    function myToggler(where)
    {
            $('html, body').animate({
                scrollTop: $("#" + where).offset().top
            }, 1000);
    }
    </script>    
</body>

</html>

