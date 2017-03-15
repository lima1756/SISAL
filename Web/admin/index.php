<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrador</title>

    <!-- Bootstrap Core CSS -->
    <link href="../dataSource/css/templates/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../dataSource/css/templates/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dataSource/css/templates/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../dataSource/css/templates/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../dataSource/css/templates/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <a class="navbar-brand" href="index.html">SISAL</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> Usuario <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
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
                            <a href="registerData"><i class="fa fa-edit fa-fw"></i> Registrar medico</a>
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
                    <h1 class="page-header">Inicio</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar-check-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">4</div>
                                    <div>Citas de hoy</div>
                                </div>
                            </div>
                        </div>
                        <a href="dates">
                            <div class="panel-footer">
                                <span class="pull-left">Ver todas</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Historial</div>
                                    <div>Pacientes</div>
                                </div>
                            </div>
                        </div>
                        <a href="patients">
                            <div class="panel-footer">
                                <span class="pull-left">Ver historial de pacientes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-pencil-square-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Registro</div>
                                    <div>Registro medico</div>
                                </div>
                            </div>
                        </div>
                        <a href="registerData">
                            <div class="panel-footer">
                                <span class="pull-left">Realizar registro de paciente</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-hospital-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Hospital</div>
                                    <div>Información</div>
                                </div>
                            </div>
                        </div>
                        <a href=".." target="_blank">
                            <div class="panel-footer">
                                <span class="pull-left">Detalles de la institución</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Citas del día
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="patients/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID DEL USUARIO PARA VERLO DIRECTAMENTE EN LA PAGINA DE PACIENTES -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Luis Iván Morett
                                    <span class="pull-right text-muted small"><em>9:00</em>
                                    </span>
                                </a>
                                <a href="patients/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID DEL USUARIO PARA VERLO DIRECTAMENTE EN LA PAGINA DE PACIENTES -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> José Francisco Martinez
                                    <span class="pull-right text-muted small"><em>12:00</em>
                                    </span>
                                </a>
                                <a href="patients/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID DEL USUARIO PARA VERLO DIRECTAMENTE EN LA PAGINA DE PACIENTES -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Brenda Samantha Ávila
                                    <span class="pull-right text-muted small"><em>15:00</em>
                                    </span>
                                </a>
                                <a href="patients/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID DEL USUARIO PARA VERLO DIRECTAMENTE EN LA PAGINA DE PACIENTES -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Carlos Rosales
                                    <span class="pull-right text-muted small"><em>18:00</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="patients/?id=all" class="btn btn-default btn-block">Ver todos</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Notas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <li class="clearfix">
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> Hace 12 mins
                                            </small>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> Hace 8 mins
                                            </small>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> Hace 6 mins 
                                            </small>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> Hace 2 mins 
                                            </small>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <form name="notesForm "id="notesForm" action="../doctor/" method="POST">
                                    <div class="input-group">
                                        <textarea name="note" id="note" class="form-control input-sm" placeholder="Escribe tu nota aqui..."></textarea>
                                        <span class="input-group-btn">
                                            <input type="submit" class="full-size btn btn-warning btn-sm" id="submit"/>    
                                        </span>
                                    </div>
                            </form>
                        </div>
                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../dataSource/js/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../dataSource/js/templates/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../dataSource/js/templates/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../dataSource/js/templates/raphael.min.js"></script>
    <script src="../dataSource/js/templates/morris.min.js"></script>
    <script src="../dataSource/js/templates/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dataSource/js/templates/sb-admin-2.js"></script>

</body>

</html>
