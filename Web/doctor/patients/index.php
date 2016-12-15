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
    <link href="../../dataSource/css/templates/bootstrap.min.css" rel="stylesheet">

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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i>Proximas Citas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="tables.html">Quirurgicas</a>
                                </li>
                                <li>
                                    <a href="tables.html">Clinicas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Registro medico</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-users fa-fw"></i> Pacientes</a>
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
                <div class="col-lg-12">
                    <form role="form">
                    <div class="form-group input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-lg btn-block">Ver todos los pacientes</button>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <form role="form">
                    <div class="form-group input-group">
                        <label>Buscar paciente</label>
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Una persona bien chingona
                        </div>
                        
                                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
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
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Medicación
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="alert alert-success alert-dismissable">
                                
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </div>
                            <div class="alert alert-success alert-dismissable">
                                
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </div>
                            <div class="alert alert-success alert-dismissable">
                                
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </div>
                            <div class="alert alert-success alert-dismissable">
                                
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detalles del paciente
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
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
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                
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

</body>

</html>
