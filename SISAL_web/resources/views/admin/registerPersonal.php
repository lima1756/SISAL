<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

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
                            <a href="/dashboard"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i>Personal<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="dates/?type=doctors">Doctores</a>
                                </li>
                                <li>
                                    <a href="dates/?type=patients">Pacientes</a>
                                </li>
                                <li>
                                    <a href="dates/?type=recepcionist">Recepcionistas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="registerPersonal"><i class="fa fa-edit fa-fw"></i> Registrar medico</a>
                        </li>
                        <li>
                            <a href="patients"><i class="fa fa-users fa-fw"></i> Pacientes</a>
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
                    <h1 class="page-header">Registrar Empleado</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

                         <div class="form-group">
                         <label>Nombre:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                         <label>Apellido Paterno:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                         <label>Apellido Materno:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>

                        <div class="form-group">
                         <label>Usuario:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                         <label>Contraseña:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                         <label>Correo:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                         <label>Domicilio:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                         <label>Municipio:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Codigo Postal:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Telefono:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Celular:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Genero:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>No. Social:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Fecha Nacimiento:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Ocupación:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                        <label>Puesto:</label>
                            <textarea class="form-control" rows="1" placeholder=" "></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">Guardar</button>
                            <button type="reset" class="btn btn-select">Reiniciar</button> 
                        </div>       
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

    <!-- Custom Theme JavaScript -->
    <script src="../../dataSource/js/templates/sb-admin-2.js"></script>

</body>

</html>
