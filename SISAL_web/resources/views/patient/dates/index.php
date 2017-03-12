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
                            <a href="#"><i class="fa fa-table fa-fw"></i>Mis citas</a>
                        </li>
                        <li>
                            <a href="../doctors"><i class="fa fa-user-md fa-fw"></i> Mis médicos</a>
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
                    <h1 class="page-header">Citas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-head">
                            <form>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="btn">Fecha de cita: </label><input class=" btn btn-default" type="date"/>
                                    <label class="btn">Doctor: </label>
                                    <select class="btn btn-default">
                                        <!--!!!!!!!!!!!LEER: Los doctores se obtendran de la base de datos-->
                                        <option>doc1</option>
                                        <option>doc2</option>
                                    </select>
                                    &nbsp&nbsp
                                    <input type="checkbox" name="disponible" id="disponible" autocomplete="off"/>
                                        <div class="btn-group">
                                            <label for="disponible" class="btn btn-default">
                                                <span class="fa fa-check"></span>
                                                <span>&nbsp</span>
                                            </label>
                                            <label for="disponible" class="btn btn-default active">
                                                Ver solo proximas citas
                                            </label>
                                        </div>
                                    <input class="btn btn-primary"type="submit" value="Ver citas"/>
                                </div>
                            </form>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Ver información</th>
                                        <th>Tipo</th>
                                        <th>Doctor</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ESTOS DATOS SOLO SON DE VISUALIZACIÓN LOS DATOS REALES LOS OBTENDRA MEDIANTE AJAX -->
                                    <tr class="odd gradeX">
                                        <div class="radio">
                                            <td><input type="radio" name="optradio"/></td>
                                        </div>
                                        <td>Quirurgica</td>
                                        <td>Doc1</td>
                                        <td>28-11-2016</td>
                                        <td>16:00</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <div class="radio">
                                            <td><input type="radio" name="optradio"/></td>
                                        </div>
                                        <td>Clinica</td>
                                        <td>Doc12</td>
                                        <td>28-12-2016</td>
                                        <td>16:00</td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <div class="radio">
                                            <td><input type="radio" name="optradio"/></td>
                                        </div>
                                        <td>Clinica</td>
                                        <td>Doc3</td>
                                        <td>28-11-2019</td>
                                        <td>15:00</td>
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="panel-title">Doc1: 28-11-2016::16:00</label>
                        </div>
                        <div class="panel-body">
                            <div class="panel-heading">
                                <a href="#medicinas" role ="tab" data-toggle="collapse" data-target="#medicinas" data-parent="#tablist">
                                    <h4>Medicamentos recetados:</h4> 
                                </a>
                            </div>
                            <div class="panel-body collapse indent" id="medicinas"  >
                                <table width="100%" class="table table-striped table-bordered table-hover" id="tabla-medicinas">
                                    <thead>
                                        <tr>
                                            <th>Nombre medicamento</th>
                                            <th>Cada</th>
                                            <th>Iniciando a las</th>
                                            <th>Indicaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- ESTOS DATOS SOLO SON DE VISUALIZACIÓN LOS DATOS REALES LOS OBTENDRA MEDIANTE AJAX -->
                                        <tr class="odd gradeX">
                                            <td>Paracetamos</td>
                                            <td>8:00</td>
                                            <td>24:00</td>
                                            <td>100mg</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Loratadina</td>
                                            <td>10:00</td>
                                            <td>12:00</td>
                                            <td>500mg</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Zenhale</td>
                                            <td>12:00</td>
                                            <td>9:00</td>
                                            <td>Tomar durante 20 dias, mañana y noche dos tomas</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
                            </div>
                            <div class="panel-heading">
                                <a href="#indicaciones" role ="tab" data-toggle="collapse" data-target="#indicaciones" data-parent="#tablist">
                                    <h4>Indicaciones terapeuticas:</h4> 
                                </a>
                            </div>
                            <div class="panel-body collapse indent" id="indicaciones"  >
                                <label>Inserte indicaciones aqui</label>
                            </div>
                            <div class="panel-heading">
                                <a href="#estudios" role ="tab" data-toggle="collapse" data-target="#estudios" data-parent="#tablist">
                                    <h4>Estudios médicos:</h4> 
                                </a>
                            </div>
                            <div class="panel-body collapse indent" id="estudios"  >
                                <label>Inserte Estudios médicos a realizar aqui</label>
                            </div>
                            <div class="panel-heading">
                                <a href="#adicionales" role ="tab" data-toggle="collapse" data-target="#adicionales" data-parent="#tablist">
                                    <h4>Indicaciones adicionales:</h4> 
                                </a>
                            </div>
                            <div class="panel-body collapse indent" id="adicionales"  >
                                <label>Inserte Indicaciones adicionales aqui</label>
                            </div>
                            <form>
                                <input class="btn btn-warning" type="submit" value="Ver receta"/>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->


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
        $('#dataTables-example').DataTable( {
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ citas por página",
                "zeroRecords": "No se encontro nada",
                "info": "Mostrando página Cita _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado por _MAX_ total de citas)"
            }
        } );
    } );
    $(document).ready(function() {
        $('#tabla-medicinas').DataTable( {
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ medicinas por página",
                "zeroRecords": "No se encontro nada",
                "info": "Mostrando pagina de medicinas _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado por _MAX_ total de medicinas)"
            }
        } );
    } );
    </script>
    
</body>

</html>
