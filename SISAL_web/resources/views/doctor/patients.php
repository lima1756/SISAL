<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $pacientes = dbConnection::select(["citas.id_paciente", "usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno", "MAX(citas.fecha_hora) as ultima"],
        "citas",
        [["citas.id_medico", logData::getData("id_usuario")]],
        [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]],
        "GROUP BY citas.id_paciente");
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
                <a class="navbar-brand" href="..">SISAL</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> Usuario <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Cerrar Sesión</a>
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
                            <a href=".."><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i>Proximas Citas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../dates/?type=surgery">Quirurgicas</a>
                                </li>
                                <li>
                                    <a href="../dates/?type=clinic">Clinicas</a>
                                </li>
                                <li>
                                    <a href="../dates/?type=all">Todas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="../registerData"><i class="fa fa-edit fa-fw"></i> Registro medico</a>
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
            <div class="row">
                <!-- BOTON DE TODOS -->
                <?php if(isset($_GET['id'])):?>
                    <div class="col-lg-12">
                <?php else: ?>
                    <div class="col-lg-12" style="visibility: hidden; display:none;">
                <?php endif; ?>
                    <form role="form">
                    <div class="form-group input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-lg btn-block">Ver todos los pacientes</button>
                            </button>
                        </span>
                    </div>
                    </form>
                </div>
                <!-- LISTA DE PACIENTES -->
                <?php if(isset($_GET['id'])): ?>
                    <div class="col-lg-12" style="visibility: hidden; display:none;">
                <?php else: ?>
                    <div class="col-lg-12" >
                <?php endif; ?>
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Usuario</th>
                                        <th>Paciente</th>
                                        <th>Ultima consulta</th>
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
                                        <td><?php echo $p['ultima']; ?></td>
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
                    <form name="formulario" id="formulario">
                        <div class="panel panel-default"aria-multiselectable="true">
                            <div class="panel-heading">
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-warning" onclick="edicion(); return false;" type="submit" id="editar">Editar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-success" type="submit" id="aceptar" style="display:none;">Aceptar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-danger" type="submit" id="cancelar" onclick="cancelacion(); return false;" style="display:none;">Cancelar</button></span>
                                <span><h2 id="nombre_completo" name="nombre_completo"></h2></span>
                            </div>
                            <div id="tablist">
                                <!-- Desplegable información Personal--> 
                                <div>
                                    <a href="#pInf" data-toggle="collapse" role ="tab" data-target="#pInf" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Información personal</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="pInf" >
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Nombre" id="nombre" name="nombre" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Apellido Paterno" id="apellidoPaterno" name="apellidoPaterno" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Apellido Materno" id="apellidoMaterno" name="apellidoMaterno" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Domicilio" id="domicilio" name="domicilio" disabled/>
                                        </div>
                                        <!--Ver si esto se puede hacer dinamicamente con un select y una tabla de ciudades, estados y paises-->
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Estado" name="Estado" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ciudad" name="Ciudad" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Código Postal" id="codigoPostal" name="codigoPostal" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono oficina" id="ofTel" name="ofTel" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Correo Electrónico" id="email" name="email" disabled/>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="genero" name="genero" disabled>
                                                <option>Género</option>
                                                <option value="m">Masculino</option>
                                                <option value="f">Femenino</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="No. de Seguridad social" id="seguroSocial" name="seguroSocial" disabled/>
                                        </div>
                                        <?php /*<div class="form-group">
                                            <input class="form-control" type="text" placeholder="Lugar de nacimiento" id="lugarNacimiento" name="lugarNacimiento" disabled/>
                                        </div> */?>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="fechaNacimiento" name="fechaNacimiento" disabled/>
                                        </div>
                                        <div class="form-group">
                                        <!--CALCULAR AQUI LA EDAD--><label class="form-control" id="edad">xy años</label>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ocupación" id="ocupacion" name="ocupacion" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Desplegable Antecedentes personales--> 
                                <?php $sangres = dbConnection::select(["tipo", "id_sangre"], "tipo_sangre"); ?>
                                <div>
                                    <a href="#aPer" role ="tab" data-toggle="collapse" data-target="#aPer" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Antecedentes personales</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="aPer">
                                        <div class="form-group">
                                            <label>Tipo de sangre</label>
                                            <select class="form-control" name="sangre" id="sangre" disabled>
                                                <?php foreach($sangres as $s):?>
                                                    <option value="<?php echo $s['tipo'];?>"> <?php echo $s['tipo'];?> </option>
                                                <?php endforeach; ?>
                                                <option value="otro">Sin seleccionar</option>
                                            </select>
                                        </div>
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
                                        <div class="form-group">
                                            <label>Antecedentes hereditarios</label>
                                            <textarea class="form-control" name="antecedentesHereditarios" id="antecedentesHereditarios" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes patológicos</label>
                                            <textarea class="form-control" name="antecedentesPatologicos" id="antecedentesPatologicos" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes no patológicos</label>
                                            <textarea class="form-control" name="antecedentesNoPatologicos" id="antecedentesNoPatologicos" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Desplegable Interrogatorio de antecedentes médicos--> 
                                <div>
                                    <a href="#int" role ="tab" data-toggle="collapse" data-target="#int" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Interrogatorio</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="int"  >
                                        <div class="form-group">
                                            <label>Antecedentes cardiovasculares</label>
                                            <textarea class="form-control" name="antecedentesCardio" id="antecedentesCardio" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes digestivos</label>
                                            <textarea class="form-control" name="antecedentesDigest" id="antecedentesDigest" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes endocrinos</label>
                                            <textarea class="form-control" name="antecedentesEndocr" id="antecedentesEndocr" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes hemolinfatico</label>
                                            <textarea class="form-control" name="antecedentesHemo" id="antecedentesHemo" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de Músculo-Esquelético</label>
                                            <textarea class="form-control" name="antecedentesMusc" id="antecedentesMusc" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de Piel y anexos</label>
                                            <textarea class="form-control" name="antecedentesPiel" id="antecedentesPiel" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de aparato reproductor</label>
                                            <textarea class="form-control" name="antecedentesRepr" id="antecedentesRepr" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de aparato respiratorio</label>
                                            <textarea class="form-control" name="antecedentesResp" id="antecedentesResp" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de sistema nervioso</label>
                                            <textarea class="form-control" name="antecedentesNerv" id="antecedentesNerv" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de sistemas generales</label>
                                            <textarea class="form-control" name="antecedentesGene" id="antecedentesGene" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Antecedentes de aparato urinario</label>
                                            <textarea class="form-control" name="antecedentesUri" id="antecedentesUri" disabled></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desplegable Estilo de vida--> 
                                <!--Hace que si no esta check se desactive y viceversa con lo que lo ocupen-->
                                <div>
                                    <a href="#eVid" role ="tab" data-toggle="collapse" data-target="#eVid" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Estilo de vida</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="eVid"  >
                                        <div class="form-group">
                                            <input type="checkbox" name="ejercicio" id="ejercicio" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="ejercicio" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="ejercicio" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Realiza ejercicio?
                                                </label>
                                                <label class="btn">Veces a la semana:&nbsp</label><input type="number" class="btn btn-default" value="0" min="0" max="7" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="btn-group">
                                                <label class="btn">Horas de sueño diarias:&nbsp</label><input type="number" class="btn btn-default" value="0" min="0" max="20" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="desayuna" id="desayuna" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="desayuna" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="desayuna" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Desayuna?
                                                </label>
                                                <label class="btn">Comidas al día:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="10" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="cafe" id="cafe" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="cafe" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="cafe" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Toma Café?
                                                </label>
                                                <label class="btn">Tazas al día:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="refresco" id="refresco" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="refresco" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="refresco" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Toma refresco?
                                                </label>
                                                <label class="btn">Vasos al día:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="dieta" id="dieta" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="dieta" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="dieta" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Sigue alguna dieta?
                                                </label>
                                            </div>
                                            <textarea type="text" placeholder="Información sobre la dieta" class="form-control" disabled></textarea>
                                        </div>
                                        <!--IMPORTANTE CUANDO SE HAGA JS: para deshabilitar los checkbox es necesario deshabilitar el input, el label de la palomita y el label de la pregunta:-->
                                        <div class="form-group">
                                            <input type="checkbox" name="alcohol" id="alcohol" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="alcohol" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="alcohol" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Consume Alcohol?
                                                </label>
                                                <label class="btn">Edad a la que comenzó a beber:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="80" disabled/>
                                                <label class="btn">Vasos de bebidas alcoholicas al día:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="ex-Alcoholico" id="ex-Alcoholico" autocomplete="off"/>
                                            <div class="btn-group">
                                                <label for="ex-Alcoholico" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="ex-Alcoholico" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿ex-Alcoholico?
                                                </label>
                                                <label class="btn">Edad a la que dejó de beber:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="80" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="fuma" id="fuma" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="fuma" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="fuma" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Fuma?
                                                </label>
                                                <label class="btn">Edad a la que comenzó a fumar:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="80" disabled/>
                                                <label class="btn">Cigarrillos al día:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="ex-fumador" id="ex-fumador" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="ex-fumador" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="ex-fumador" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Ex-fumador?
                                                </label>
                                                <label class="btn">Edad a la que dejó de fumar:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="80" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="fumador-pasivo" id="fumador-pasivo" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="fumador-pasivo" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="fumador-pasivo" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Fumador-pasivo?
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="droga" id="droga" autocomplete="off"/>
                                            <div class="btn-group">
                                                <label for="droga" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="droga" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Consume algun tipo de droga?
                                                </label>
                                                <label class="btn">Edad a la que comenzó a consumir:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="80" disabled/>
                                            </div>
                                            <input type="checkbox" name="droga-intra" id="droga-intra" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="droga-intra" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="droga-intra" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿Consume algun tipo de droga intravenosa?
                                                </label>
                                            </div>
                                            <textarea type="text" placeholder="Anotación acerca de las drogas consumidas" class="form-control" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="ex-adicto" id="ex-adicto" autocomplete="off" disabled/>
                                            <div class="btn-group">
                                                <label for="ex-adicto" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="ex-adicto" class="btn btn-default active" id="checkbox" disabled>
                                                    ¿ex-adicto?
                                                </label>
                                                <label class="btn">Edad a la que dejó de consumir:&nbsp</label><input class="btn btn-default" type="number" value="0" min="0" max="50" disabled/>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <!-- Desplegable Alergias--> 
                                <div>
                                    <a href="#aler" role ="tab" data-toggle="collapse" data-target="#aler" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Alergias</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="aler"  >
                                        <div class="form-group">
                                            <textarea class="form-control" placeholder="Alergias tanto a medicamentos como a materiales o alimentos" disabled></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desplegable Citas--> 
                                <div>
                                    <a href="#citas" role ="tab" data-toggle="collapse" data-target="#citas" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Citas</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="citas"  >
                                        <div class="form-group">
                                            <label>Fecha de cita</label>
                                            <select class="form-control">
                                                <option>12-12-12</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="alert">
                                            Info: Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                                        </div>
                                        <div class="alert">
                                            Mas Info: Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                                        </div>
                                        <div class="alert">
                                            Aun mas Info: Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                                        </div>
                                        <div class="alert">
                                            Info de la info: Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel -->
                    </form>
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
    var json;

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "40%", "targets": 2 }
            ],
            "order": [[ 3, "desc" ]]
        });
             $('input[type=radio][name=paciente]').change(function() {
                 cancelacion();
                var csrfVal="<?php echo csrf_token(); ?>";
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfVal
                    }
                })
                $.post("/ajaxDP", { <?php //DP se refiere a Doctor-Patients ?>
                    'patientId': id
                },
                function(data, status){
                    var json = JSON.parse(data);
                    if(json != 0)
                    {
                        $('#toda_info').show();
                        $('#toda_info').attr("style", "");
                        document.getElementById('toda_info').scrollIntoView();
                        $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                    }
                    $('#nombre').val(json.generales.nombre);
                    $('#apellidoPaterno').val(json.generales.apellidoPaterno);
                    $('#apellidoMaterno').val(json.generales.apellidoMaterno);
                    $('#domicilio').val(json.generales.domicilio);
                    $('#codigoPostal').val(json.generales.codigoPostal);
                    $('#domTel').val(json.generales.telefonoDomiciliar);
                    $('#ofTel').val(json.generales.telefonoDomiciliar);
                    $('#email').val(json.generales.telefonoDomiciliar);
                    if(json.generales.genero=="Masculino")
                    {
                        $('#genero').val("m");
                    }
                    else
                    {
                        $('#genero').val("f");
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
                    $('#sangre').val(json.sangre.tipo);
                    $('#tabaquismoCantidad').val(json.antecedentes.tabaquismo);
                    $('#alcoholismoCantidad').val(json.antecedentes.alcoholismo);
                    $('#antecedentesHereditarios').val(json.antecedentes.antecedentesHereditarios);
                    $('#antecedentesPatologicos').val(json.antecedentes.antecedentesPatologicos);
                    $('#antecedentesNoPatologicos').val(json.antecedentes.antecedentesNoPatologicos);
                    $('#alcoholismoCantidad').val(json.antecedentes.alcoholismo);
                    $('#alcoholismoCantidad').val(json.antecedentes.alcoholismo);
                    
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
                });
                /*$.post("/ajaxSRTI", {
                    'ticketid': id
                },
                function(data, status){
                    if(data=="-1"){
                        $('#imgn').attr("src", "")
                        $('#imgn').attr('alt', 'No se subió ninguna imagen');
                    }
                    else{
                        var json = JSON.parse(data);
                        $('#imgn').attr("src", "/storage/ticketImages/" + json.nombre)
                        $('#imgn').attr('alt', 'img');
                    }
                });*/
            });
            
            } );
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
        }
        function cancelacion()
        {
            $('#formulario :input').prop('disabled', true);
            $('#editar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
            $('#aceptar').prop('disabled', false);
            $('label[id="checkbox"]').attr('disabled', true);
            $('#editar').show();
            $('#cancelar').hide();
            $('#aceptar').hide();
        }

    </script>    
</body>

</html>
