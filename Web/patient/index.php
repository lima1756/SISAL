<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

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
                <a class="navbar-brand" href="#">SISAL</a>
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
                            <a href="dates"><i class="fa fa-table fa-fw"></i>Mis citas</a>
                        </li>
                        <li>
                            <a href="doctors"><i class="fa fa-user-md fa-fw"></i> Mis médicos</a>
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
            <div class="row grid">
                <div class="grid-sizer col-xs-1 col-md-1 col-lg-1"></div> <!--Aunque esta linea no parezca importante NO BORRAR-->
                
                <div class="col-lg-3 col-md-6 grid-item">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar-check-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">5</div>
                                    <div>Medicamentos de hoy</div>
                                </div>
                            </div>
                        </div>
                        <a href="dates">
                            <div class="panel-footer">
                                <span class="pull-left">Ver receta</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 grid-item">
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
                <!--Timeline Medicinas-->
                <div class="col-lg-6 col-md-6 grid-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-heartbeat fa-fw"></i>Medicamentos del día
                        </div>
                        <div class="panel-body">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-badge success"><i class="fa fa-check"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Medicamento 1</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 7:00 </small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-badge success"><i class="fa fa-check"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Medicamento 2</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 10:00 </small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-badge success"><i class="fa fa-check"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Medicamento 3</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 12:00 </small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-badge warning"><i class="fa fa-minus"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Medicamento 4</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 14:00 </small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-badge warning"><i class="fa fa-minus"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Medicamento 1</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 16:00 </small>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!--/.Panel body-->
                    </div>
                    <!--/.Panel-->
                </div>
                <!-- /.col lg 6 -->
                <!-- Proximas citas -->
                <div class="col-lg-6 col-md-6 grid-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Proximas citas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="dates/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID de la cita PARA VERLO DIRECTAMENTE EN LA PAGINA DE citas -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Doctor < Inserte nombre de docotor >
                                    <span class="pull-right text-muted small"><em>22-01-2017 9:00</em>
                                    </span>
                                </a>
                                <a href="dates/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID de la cita PARA VERLO DIRECTAMENTE EN LA PAGINA DE citas -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Doctor < Inserte nombre de docotor >
                                    <span class="pull-right text-muted small"><em>23-03-2017 15:00</em>
                                    </span>
                                </a>
                                <a href="dates/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID de la cita PARA VERLO DIRECTAMENTE EN LA PAGINA DE citas -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Doctor < Inserte nombre de docotor >
                                    <span class="pull-right text-muted small"><em>24-04-2017 18:00</em>
                                    </span>
                                </a>
                                <a href="dates/?id=IMPORTANTE" class="list-group-item"> <!-- IMPORTANTE, AL MOMENTO DE PROGRAMAR YA BIEN ESTO, HACER QUE SE GUARDE EL ID de la cita PARA VERLO DIRECTAMENTE EN LA PAGINA DE citas -->
                                    <i class="fa fa-calendar-check-o fa-fw"></i> Doctor < Inserte nombre de docotor >
                                    <span class="pull-right text-muted small"><em>25-05-2017 16:00</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="patients/?id=all" class="btn btn-default btn-block">Ver todas</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col lg 6 -->
                
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

    <!-- Masonry -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js"></script>
    <script>
        $('.grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            percentPosition: true
            });

    </script>

</body>

</html>
