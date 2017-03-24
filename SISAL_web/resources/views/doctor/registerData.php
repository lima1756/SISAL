<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $tiempoCita = dbConnection::select(["medicos.tiempo_consulta"], "medicos", [["medicos.id_usuario", logData::getData("id_usuario")]]);
    $today = date("Y-m-d H:i:s", strtotime('-' . $tiempoCita[0]['tiempo_consulta'] . ' minutes'));
    $tomorrow = date("Y-m-d", strtotime('+1 day')) . " 00:00:00";
    $cita = dbConnection::select(["usuarios.id_usuario", "TIME(fecha_hora) AS hora", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"], 
        "citas", 
        [["citas.id_medico", logData::getData("id_usuario")], ["citas.fecha_hora", $today, ">"], ["citas.fecha_hora", $tomorrow, "<"]], 
        [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]],
        "order by fecha_hora ASC LIMIT 1");
    $pacientes = dbConnection::select(["citas.id_paciente", "usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"],
        "citas",
        [["citas.id_medico", 1003]],
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
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Registro medico</a>
                        </li>
                        <li>
                            <a href="../patients"><i class="fa fa-users fa-fw"></i> Pacientes</a>
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
                    <h1 class="page-header" id="pageHeader"><?php echo date("d/m/Y") . " - "; echo $cita[0]['nombre'] . " " . $cita[0]['apellidoPaterno'] . " " . $cita[0]['apellidoMaterno']; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form">
                                        <label>Cambiar paciente</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-search">
                                                <input type="text" name="patient" list="patients" id="patient" class="form-control" placeholder="<?php echo $cita[0]['nombre'] . " " . $cita[0]['apellidoPaterno'] . " " . $cita[0]['apellidoMaterno']; ?>"/>
                                                <datalist id="patients">
                                                    <?php foreach($pacientes as $key => $p): ?>
                                                        <option value="<?php  echo $p['usuario'] . " - " . $p['nombre'] . " " . $p['apellidoPaterno'] . " " . $p['apellidoMaterno'];?>">
                                                    <?php endforeach; ?>
                                                </datalist>
                                                <button class="btn btn-default" type="button" onclick="getNameAndID()">Seleccionar
                                                </button>
                                            </span>
                                        </div> 
                                    </form>
                                    <form role="form">   
                                        <input type="text" name="id" id="idPatient" value="<?php echo $cita[0]['id_usuario']?>" hidden/> 
                                        <!-- Interrogatorio -->
                                        <div class="form-group">
                                            <h2 class="header">Interrogatorio:</h2>
                                            <textarea class="textarea50" placeholder="Motivo de consulta:" rows="10"></textarea>
                                            <textarea class="textarea50" placeholder="Síntomas:" rows="10"></textarea>
                                        </div>
                                        <!-- Exploración -->
                                        <div class="form-group">
                                            <h2 class="header">Exploración:</h2>
                                            <table>
                                                <tr>
                                                    <td><label>Peso: </label></td>
                                                    <td colspan="3"><input type="number"/></td>
                                                    <td><label>kg</label></td>
                                                    <td rowspan="6" width="50%"><textarea placeholder="Exploración fisica:" rows="10" cols="50"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Talla: </label></td>
                                                    <td  colspan="3"><input type="number"/></td>
                                                    <td><label>Cm</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Frec Respiratoria: </label></td>
                                                    <td  colspan="3"><input type="number"/></td>
                                                    <td><label>por minuto</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Presion alterial: </label></td>
                                                    <td><input type="number" class="inputLowNumber"/></td>
                                                    <td align="center"><label>/</label></td>
                                                    <td><input type="number" class="inputLowNumber"/></td>
                                                    <td><label>mmHg</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Temperatura: </label></td>
                                                    <td  colspan="3"><input type="number"/></td>
                                                    <td><label>°C</label></td>
                                                </tr>
                                                <tr>
                                                    <td><label>Frecuencia cardiaca: </label></td>
                                                    <td  colspan="3"><input type="number"/></td>
                                                    <td><label>ppm</label></td>
                                                </tr>
                                            </table>
                                        </div> 
                                        <!-- Diagnostico -->                  
                                        <div class="form-group">
                                            <h2 class="header">Diagnostico:</h2>
                                            <input class="form-control" type="text" placeholder="Enfermedad"/>
                                            <div class="form-group">
                                                <label>Estado de la enfermedad:</label>
                                                <select class="form-control">
                                                    <option>Sin determinar</option>
                                                    <option>Grave</option>
                                                    <option>Controlado</option>
                                                    <option>Leve</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Notas:</label>
                                                <textarea class="form-control" rows="3" placeholder="Notas que se requieran sobre la enfermedad o su estado"></textarea>
                                            </div>
                                        </div>
                                        <!-- Tratamiento --> 
                                        <div>   
                                            <h2 class="header">Tratamiento:</h2>              
                                            <div class="form-group">
                                                <label>Cantidad de medicamentos:</label>
                                                <input type="number" value="1" min="0" max="20"/>
                                            </div>
                                            <div class="form-group meds">
                                                <label>Nombre:</label>
                                                <input type="text"/>
                                                <label>Cada:</label>
                                                <select>
                                                    <option>1 hora</option>
                                                    <option>2 horas</option>
                                                    <option>4 horas</option>
                                                    <option>6 horas</option>
                                                    <option>8 horas</option>
                                                    <option>12 horas</option>
                                                    <option>24 horas</option>
                                                </select>
                                                <label>Iniciando a las:</label>
                                                <select>
                                                    <option>5 horas</option>
                                                    <option>6 horas</option>
                                                    <option>7 horas</option>
                                                    <option>8 horas</option>
                                                    <option>9 horas</option>
                                                    <option>10 horas</option>
                                                    <option>11 horas</option>
                                                    <option>12 horas</option>
                                                </select>
                                                <input type="text" class="form-control" placeholder="Cantidad, mm, mg, indicaciones adicionales del medicamento, etc."/>
                                            </div>
                                            <div class="form-group">
                                                <label>Indicaciones extra:</label>
                                                <textarea class="form-control" rows="3" placeholder="Indicaciones terapeuticas adicionales"></textarea>
                                            </div>
                                        </div>
                                        <!-- Estudios -->                  
                                        <div class="form-group">
                                            <h2 class="header">Estudios:</h2>
                                            <label>Orden</label>
                                            <textarea class="form-control" rows="3" placeholder="Ingrese aqui la orden(es) que requiera el paciente, estas se incluiran en la receta"></textarea>
                                        </div>
                                        <!-- Notas adicionales -->
                                        <div class="form-group">
                                            <h2 class="header">Notas adicionales:</h2>
                                            <textarea class="form-control" rows="3" placeholder="Ingrese aqui las notas adicionales que requiera"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-default">Guardar</button>
                                        <button type="reset" class="btn btn-default">Reiniciar</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../dataSource/js/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="../../dataSource/js/templates/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../dataSource/js/templates/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dataSource/js/templates/sb-admin-2.js"></script>


    <script>
        function getNameAndID()
        {
            var date = "<?php echo date("d/m/Y"); ?>";
            
            var nombres = 
            {
                <?php foreach($pacientes as $p): ?>
                    <?php  echo $p['id_paciente']; ?>: "<?php echo $p['usuario'] . " - " . $p['nombre'] . " " . $p['apellidoPaterno'] . " " . $p['apellidoMaterno'];?>", <?php echo "\n"; ?>
                <?php endforeach; ?>
            }
            for(key in nombres)
            {
                if(nombres[key]==$("#patient").val())
                {
                    var name = nombres[key].substring(nombres[key].indexOf('-'));
                    $("#idPatient").attr('value', key);
                    $("#pageHeader").html(date + " " + name);
                    document.getElementById("patient").value = "";
                    $("#patient").attr('placeholder', name.substring(2));
                    break;
                }
                else
                {
                    console.log("NADA");
                }
            }
            
        }
        
    </script>
</body>

</html>
