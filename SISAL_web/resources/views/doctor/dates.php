<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $today = date("Y-m-d") . " 00:00:00";
    $tipo = $_GET['type'];
    if($tipo=="all")
    {
        $citas = dbConnection::select(["DATE_FORMAT(fecha_hora,'%d/%m/%Y') AS fecha", "TIME(fecha_hora) AS hora", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"], "citas", 
            [["citas.id_medico", logData::getData("id_usuario")], ["citas.fecha_hora", $today, ">"]], 
            [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
    }
    elseif($tipo=="clinic") //2
    {
        $citas = dbConnection::select(["DATE_FORMAT(fecha_hora,'%d/%m/%Y') AS fecha", "TIME(fecha_hora) AS hora", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"], "citas", 
            [["citas.id_medico", logData::getData("id_usuario")], ["citas.fecha_hora", $today, ">"], ["citas.tipo", 2]], 
            [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
    }
    elseif($tipo=="surgery") //1
    {
        $citas = dbConnection::select(["DATE_FORMAT(fecha_hora,'%d/%m/%Y') AS fecha", "TIME(fecha_hora) AS hora", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"], "citas", 
            [["citas.id_medico", logData::getData("id_usuario")], ["citas.fecha_hora", $today, ">"], ["citas.tipo", 1]], 
            [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
    }
    else
    {
        header("Location: /dashboard/dates?type=all");
        die();
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
    <link href="../../dataSource/css/templates/bootstrap.min.css" rel="stylesheet">

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

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
                        <li><a href="../dashboard/userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                                    <a href="?type=surgery">Quirurgicas</a>
                                </li>
                                <li>
                                    <a href="?type=clinic">Clinicas</a>
                                </li>
                                <li>
                                    <a href="?type=all">Todas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="../registerData"><i class="fa fa-edit fa-fw"></i> Registro medico</a>
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
                    <?php if($tipo=="all"): ?>
                    <h1 class="page-header">Todas las Citas proximas</h1>
                    <?php elseif($tipo=="clinic"): ?>
                    <h1 class="page-header">Todas las Citas Clinicas proximas</h1>
                    <?php elseif($tipo=="surgery"): ?>
                    <h1 class="page-header">Todas las Citas Quirurgicas proximas</h1>
                    <?php endif; ?>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Paciente</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($citas as $cita): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $cita['nombre'] . " " . $cita['apellidoPaterno'] . " " . $cita['apellidoMaterno']; ?></td>                                        
                                            <td><?php echo $cita['fecha']; ?></td>
                                            <td class="center"><?php echo $cita['hora']; ?></td>
                                        </tr>                                    
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../../dataSource/js/templates/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../dataSource/js/templates/metisMenu.min.js"></script>

     
    <!-- DataTables JavaScript -->
    <script src="../../dataSource/js/jquery/jquery.dataTables.js"></script>
    <script src="../../dataSource/js/templates/dataTables.bootstrap.min.js"></script>
    <script src="../../dataSource/js/templates/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dataSource/js/templates/sb-admin-2.js"></script>
           
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            "order": [[ 1, "asc" ]]
        });
    });
    </script>

</body>

</html>
