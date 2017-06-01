<?php
     use App\myClasses\dbConnection;
    use App\myClasses\logData;
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

    <!-- FontsAwsome CSS -->
    <link href="../../dataSource/css/templates/font-awesome.css" rel="stylesheet">
    <link rel='shortcut icon' href='../dataSource/img/favicon.png' type='image/x-icon'/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                                    <a href="/dashboard/dates/?type=surgery">Quirurgicas</a>
                                </li>
                                <li>
                                    <a href="/dashboard/dates/?type=clinic">Clinicas</a>
                                </li>
                                <li>
                                    <a href="/dashboard/dates/?type=all">Todas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="../dashboard/registerData"><i class="fa fa-edit fa-fw"></i> Registro medico</a>
                        </li>
                        <li>
                            <a href="../dashboard/patients"><i class="fa fa-users fa-fw"></i> Pacientes</a>
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
                    <form>
                        <div class="panel panel-default"aria-multiselectable="true">
                            <div class="panel-heading">
                                <span><h2>Médico: <?php echo logData::getData('nombre') . " " . logData::getData('apellidoPaterno') . " " . logData::getData('apellidoMaterno'); ?></h2></span>
                            </div>
                            <br>
                            <br>
                            <div id="tablist">
                                <!-- Desplegable información Personal--> 
                                <div>
                                    <a href="#pInf" data-toggle="collapse" role ="tab" data-target="#pInf" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:80%;">
                                       <h4>Información personal</h4>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="pInf" >
                                    <table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                        <tr>
                                        <td>
                                        <label>Nombre:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" style="height: 30px; width: 80%;" value="<?php echo logData::getData('nombre'); ?>" disabled/>
                                        </div>   
                                        </td>
                                        <td>
                                        <label>Apellido Paterno:</label>                                
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="apellidoPaterno" name="apellidoPaterno" style="height: 30px; width: 80%;" placeholder="Apellido Paterno" value="<?php echo logData::getData('apellidoPaterno'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Apellido Materno:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="apellidoMaterno" name="apellidoMaterno" style="height: 30px; width: 80%;" placeholder="Apellido Materno" value="<?php echo logData::getData('apellidoMaterno'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Domicilio:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="Domicilio"name="Domicilio" placeholder="Domicilio" style="height: 30px; width: 80%;" value="<?php echo logData::getData('Domicilio'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </td>
                                        <tr>
                                        <td>
                                        <label>Código postal:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Código Postal" id="codigoPostal" name="codigoPostal" style="height: 30px; width: 80%;" value="<?php echo logData::getData('codigoPostal'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Teléfono:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" style="height: 30px; width: 80%;" value="<?php echo logData::getData('telefonoDomiciliar'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Celular:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono Celular" id="celTel" name="celTel" style="height: 30px; width: 80%;" value="<?php echo logData::getData('telefonoCelular'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Correo:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Correo Electrónico" id="email" name="email" style="height: 30px; width: 80%;" value="<?php echo logData::getData('email'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Sexo:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="genero" placeholder="genero" id="genero" name="genero" style="height: 30px; width: 80%;" value="<?php echo logData::getData('genero'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>No. Seguridad social:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="No. de Seguridad social" id="seguroSocial" name="seguroSocial" style="height: 30px; width: 80%;" value="<?php echo logData::getData('noSeguroSocial'); ?>" disabled/>
                                        </div>
                                       </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Fecha de nacimiento:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="fechaNacimiento" name="fechaNacimiento" style="height: 30px; width: 80%;" value="<?php echo logData::getData('fechaNacimiento'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Ocupación:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ocupación" id="ocupacion" name="ocupacion"  style="height: 30px; width: 80%;" value="<?php echo logData::getData('Ocupacion'); ?>" disabled/>
                                        </div>
                                        </td>
                                        
                                        </tr>
                                        <tr>
                                        <td>
                                        <?php
                                            $diff = abs(strtotime(date('Y-m-d')) - strtotime(logData::getData('fechaNacimiento')));
                                            $years = floor($diff / (365*60*60*24));
                                        ?>
                                        <label>Edad:</label>
                                        <div class="form-group">
                                            <label id="edad" style="height: 30px; width: 80%;" ><?php echo ($years); ?></label>
                                        </div>
                                        </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                                <!-- Desplegable Personal--> 
                                <?php $masInfo = dbConnection::select(["*"], "medicos", [["id_usuario", logData::getData("id_usuario")]]);
                                
                                ?>
                                <br>
                                <br>
                                <div>
                                    <a href="#aPer" role ="tab" data-toggle="collapse" data-target="#aPer" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:80%;">
                                        <h4>Información de contacto</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="aPer">
                                    <table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                        <tr>
                                        <td>
                                        <label>Domicilio Particular:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Domicilio consulta particular" name="domPart" id="domPart" value="<?php echo $masInfo[0]['domicilioConsultorio'];?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Telefono emergencias:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Telefono de emergencias" name="telEme" id="telEme" value="<?php echo $masInfo[0]['telEmergencias'];?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Celular de emergencias:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Celular de emergencias" name="celEmergencias" id="celEmergencias" value="<?php echo $masInfo[0]['celEmergencias'];?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Correo:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Correo Electrónico" name="coreoAux" id="coreoAux" value="<?php echo $masInfo[0]['emailEmergencias'];?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Facebook:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Facebook" name="face" id="face" value="<?php echo $masInfo[0]['facebook'];?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Twitter:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Twitter" name="twitter" id="twitter" value="<?php echo $masInfo[0]['twitter'];?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- Desplegable de información de trabajo en consulta -->
                                <br>
                                <br>
                                <div>
                                    <a href="#info" role ="tab" data-toggle="collapse" data-target="#info" data-parent="#tablist">
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <span>&nbsp</span><span>&nbsp</span>
                                    <div class="btn btn-primary" style="width:80%;">
                                        <h4>Información laboral</h4>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="info">
                                        <table width="100%" class="table table-striped  table-hover" id="dataTables-example">
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Cedula:</label>
                                            <input class="form-control" type="text" placeholder="cedula" id="cedula" name="cedula" value="<?php echo $masInfo[0]['cedula']?>"disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Especialidad:</label>
                                            <input class="form-control" type="text" placeholder="Especialidad" id="Especialidad" name="Especialidad" value="<?php echo $masInfo[0]['especialidad']?>"disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <div class="form-group">
                                            <label>Universidad:</label>    
                                            <input class="form-control" type="text" placeholder="Universidad" id="universidad" name="universidad" value="<?php echo $masInfo[0]['universidad']?>"disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Dias de trabajo:</label>
                                        <div class="form-group">
                                            <input type="checkbox" id="lunes" name="lunes" <?php echo (strpos($masInfo[0]['horario_trabajo'], 'l') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="lunes" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="lunes" class="btn btn-default active" id="checkbox" disabled>
                                                    Lunes
                                                </label>
                                            </div>
                                            <input type="checkbox" id="martes" name="martes" <?php echo (strpos($masInfo[0]['horario_trabajo'], 'm') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="martes" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="martes" class="btn btn-default active" id="checkbox" disabled>
                                                    Martes
                                                </label>
                                            </div>
                                            <input type="checkbox" id="miercoles" name="miercoles" <?php echo (strpos($masInfo[0]['horario_trabajo'], 'x') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="miercoles" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="miercoles" class="btn btn-default active" id="checkbox" disabled>
                                                    Miercoles
                                                </label>
                                            </div>
                                            <input type="checkbox" id="jueves" name="jueves" <?php echo (strpos($masInfo[0]['horario_trabajo'], 'j') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="jueves" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="jueves" class="btn btn-default active"  id="checkbox" disabled>
                                                    Jueves
                                                </label>
                                            </div>
                                            <input type="checkbox" id="viernes" name="viernes" <?php echo (strpos($masInfo[0]['horario_trabajo'], 'v') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="viernes" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="viernes" class="btn btn-default active" id="checkbox" disabled>
                                                    Viernes
                                                </label>
                                            </div>
                                            <input type="checkbox" id="sabado" name="sabado" <?php echo (strpos($masInfo[0]['horario_trabajo'], 's') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="sabado" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="sabado" class="btn btn-default active" id="checkbox" disabled>
                                                    Sabado
                                                </label>
                                            </div>
                                            <input type="checkbox" id="domingo" name="domingo" <?php echo (strpos($masInfo[0]['horario_trabajo'], 'd') !== false ? 'checked': '');?> disabled hidden/>
                                            <div class="btn-group">
                                                <label for="domingo" class="btn btn-default" id="checkbox" disabled>
                                                    <span class="[ fa fa-check ]"></span>
                                                    <span>&nbsp</span>
                                                </label>
                                                <label for="domingo" class="btn btn-default active" id="checkbox" disabled>
                                                    Domingo
                                                </label>
                                            </div>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <?php
                                            //var_dump ($masInfo);
                                            
                                            //var_dump ($par);
                                            preg_match('/\(/',$masInfo[0]['horario_trabajo'], $par, PREG_OFFSET_CAPTURE);
                                            $inicio = $par[0][1] + 1;
                                            preg_match('/-/',$masInfo[0]['horario_trabajo'], $guion, PREG_OFFSET_CAPTURE);
                                            $fin = $guion[0][1]- $inicio;
                                            $horaStart = substr($masInfo[0]['horario_trabajo'], $inicio, $fin);
                                            $inicio2= $guion[0][1] + 1;
                                            preg_match('/\)/',$masInfo[0]['horario_trabajo'], $par2, PREG_OFFSET_CAPTURE);
                                            $fin2 = $par2[0][1] - $inicio2;
                                            $horaFin = substr($masInfo[0]['horario_trabajo'], $inicio2, $fin2);
                                            
                                        ?>
                                        
                                        <div class="form-group">
                                            <td>
                                            <label>Horario de trabajo:</label>
                                            <p><b>Inicio:</b></p>
                                            <input type="time" class="form-control" name="inicio" id="inicio" value="<?php echo $horaStart; ?>" disabled/>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <p><b>Fin:</b></p>
                                            <input type="time" class="form-control" name="fin" id="fin" value="<?php echo $horaFin; ?>" disabled/>
                                            </td>
                                            </tr>
                                            </table>
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

     <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    
</body>

</html>
