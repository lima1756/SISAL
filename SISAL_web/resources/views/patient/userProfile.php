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

    <title>Paciente</title>

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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                            <a href="/dashboard"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="../dashboard/dates"><i class="fa fa-table fa-fw"></i>Mis citas</a>
                        </li>
                        <li>
                            <a href="../dashboard/doctors"><i class="fa fa-user-md fa-fw"></i> Mis médicos</a>
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
                                <span><h2>Paciente: <?php echo logData::getData('nombre') . " " . logData::getData('apellidoPaterno') . " " . logData::getData('apellidoMaterno'); ?></h2></span>
                            </div>
                            <div id="tablist">
                                <!-- Desplegable información Personal--> 
                                <div>
                                    <div class="panel-heading">
                                        <h4>Información personal</h2>
                                    <table width="100%" class="table table-striped table-hover" id="dataTables-example">
                                    <tr><td>
                                        <label>Nombre:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" style="height: 30px; width: 100%;" value="<?php echo logData::getData('nombre'); ?>" disabled/>
                                        </div>   
                                        </td>
                                        <td>
                                        <label>Apellido Paterno:</label>                                
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="apellidoPaterno" name="apellidoPaterno" style="height: 30px; width: 100%;" placeholder="Apellido Paterno" value="<?php echo logData::getData('apellidoPaterno'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Apellido Materno:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="apellidoMaterno" name="apellidoMaterno" style="height: 30px; width: 100%;" placeholder="Apellido Materno" value="<?php echo logData::getData('apellidoMaterno'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Domicilio:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="Domicilio"name="Domicilio" placeholder="Domicilio" style="height: 30px; width: 100%;" value="<?php echo logData::getData('Domicilio'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </td>
                                        <tr>
                                        <td>
                                        <label>Código postal:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Código Postal" id="codigoPostal" name="codigoPostal" style="height: 30px; width: 100%;" value="<?php echo logData::getData('codigoPostal'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Teléfono:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" style="height: 30px; width: 100%;" value="<?php echo logData::getData('telefonoDomiciliar'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Celular:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" placeholder="Teléfono Celular" id="celTel" name="celTel" style="height: 30px; width: 100%;" value="<?php echo logData::getData('telefonoCelular'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Correo:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="email" placeholder="Correo Electrónico" id="email" name="email" style="height: 30px; width: 100%;" value="<?php echo logData::getData('email'); ?>" disabled/>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Sexo:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="genero" placeholder="genero" id="genero" name="genero" style="height: 30px; width: 100%;" value="<?php echo logData::getData('genero'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>No. Seguridad social:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="No. de Seguridad social" id="seguroSocial" name="seguroSocial" style="height: 30px; width: 100%;" value="<?php echo logData::getData('noSeguroSocial'); ?>" disabled/>
                                        </div>
                                       </td>
                                        </tr>
                                        <tr>
                                        <td>
                                        <label>Fecha de nacimiento:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="fechaNacimiento" name="fechaNacimiento" style="height: 30px; width: 100%;" value="<?php echo logData::getData('fechaNacimiento'); ?>" disabled/>
                                        </div>
                                        </td>
                                        <td>
                                        <label>Ocupación:</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ocupación" id="ocupacion" name="ocupacion"  style="height: 30px; width: 100%;" value="<?php echo logData::getData('Ocupacion'); ?>" disabled/>
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
                                            <label  id="edad" style="height: 30px; width: 100%;" ><?php echo ($years); ?></label>
                                        </div>
                                        </td>
                                        </tr>
                                    </table>
                                        
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
