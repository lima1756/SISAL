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
                <div class="col-lg-12">
                    <form role="form">
                    <div class="form-group input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-lg btn-block">Ver todos los pacientes</button>
                            </button>
                        </span>
                    </div>
                </div>
                <!-- LISTA DE PACIENTES -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Paciente</th>
                                        <th>Ultima consulta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>1alguien</td>                                        
                                        <td class="center">nombre1</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td>2alguien</td>                                        
                                        <td class="center">nombre2</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td>1alguien</td>                                        
                                        <td class="center">nombre1</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td>1alguien</td>                                        
                                        <td class="center">nombre1</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td>1alguien</td>                                        
                                        <td class="center">nombre1</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td>1alguien</td>                                        
                                        <td class="center">nombre1</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td>1alguien</td>                                        
                                        <td class="center">nombre1</td>
                                        <td>28-11-2016</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12">
                    <form>
                        <div class="panel panel-default"aria-multiselectable="true">
                            <div class="panel-heading">
                                <h2>Una persona bien chingona</h2>
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
                                            <input class="form-control" type="text" placeholder="Nombre"/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Apellido"/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Domicilio"/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Ciudad"/>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Numero de telefono"/>
                                        </div>
                                        <div class="form-group">
                                            <select>
                                                <option>Género</optio>
                                                <option>Masculino</optio>
                                                <option>Femenino</optio>
                                            </select>
                                            
                                        </div>

                                    </div>
                                </div>
                                <!-- Desplegable Antecedentes personales--> 
                                <div>
                                    <a href="#aPer" role ="tab" data-toggle="collapse" data-target="#aPer" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Antecedentes personales</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="aPer"  >
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
                                
                                <!-- Desplegable Interrogatorio--> 
                                <div>
                                    <a href="#int" role ="tab" data-toggle="collapse" data-target="#int" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Interrogatorio</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="int"  >
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

                                <!-- Desplegable Estilo de vida--> 
                                <div>
                                    <a href="#eVid" role ="tab" data-toggle="collapse" data-target="#eVid" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Estilo de vida</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="eVid"  >
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

                                <!-- Desplegable Alergias--> 
                                <div>
                                    <a href="#aler" role ="tab" data-toggle="collapse" data-target="#aler" data-parent="#tablist">
                                    <div class="panel-heading">
                                        <h4>Alergias</h2>
                                    </div>
                                    </a>                                        
                                    <div class="panel-body collapse indent" id="aler"  >
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
