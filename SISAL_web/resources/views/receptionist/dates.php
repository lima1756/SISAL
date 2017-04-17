<?php 
use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $listaDoctores = dbConnection::select(
            ['medicos.id_usuario', 'usuarios.nombre', 'usuarios.apellidoPaterno', 'usuarios.apellidoMaterno', 'usuarios.usuario'],
            "medicos",
            [],
            [['usuarios', 'medicos.id_usuario', 'usuarios.id_usuario']]);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recepcionista</title>

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
                        <li><a href="../userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                            <a href=".."><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="../dates"><i class="fa fa-table fa-fw"></i> Citas</a>
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
                            <form action="#" method="POST">
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="btn">Fecha de cita: </label><input class=" btn btn-default" id="date" name="date" type="date"/>
                                    <label class="btn">Doctor: </label>
                                    <select class="btn btn-default" name="idDoc" id="idDoc">
                                        <?php foreach($listaDoctores as $d): ?>
                                            <option value="<?php echo $d['id_usuario'];?>"><?php echo $d['usuario'] . " - " . $d['nombre'] . " " . $d['apellidoPaterno'] . " " . $d['apellidoMaterno'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    &nbsp&nbsp
                                    <input type="checkbox" name="disponible" id="disponible" />
                                        <div class="btn-group">
                                            <label for="disponible" class="btn btn-default">
                                                <span class="fa fa-check"></span>
                                                <span>&nbsp</span>
                                            </label>
                                            <label for="disponible" class="btn btn-default active">
                                                Ver solo horarios disponibles
                                            </label>
                                        </div>
                                    <button class="btn btn-primary" onclick="updateDates(); return false;">Ver citas</button>
                                </div>
                            </form>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Paciente</th>
                                        <th>Usuario</th>
                                        <th>Tipo</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                       
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <!--AL MOMENTO DE SELECCIONAR EL RADIO DE UNA CITA REGISTRADA, SE MUESTRAN LOS DATOS COMO SIGUE-->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="panel-title">Doc1: 28-11-2016::16:00</label>
                        </div>
                        <div class="panel-body">
                            <label>Usuario de paciente:</label> <p>1alguien</p>
                            <label>Nombre de paciente:</label> <p>nombre-de-alguien</p>
                            <form>
                                <input class="btn btn-danger" type="submit" value="Eliminar cita"/>
                            </form>
                        </div>
                    </div>
                </div>
                <!--AL MOMENTO DE SELECCIONAR EL RADIO DE UNA CITA NO REGISTRADA, SE PIDEN LOS DATOS COMO SIGUE-->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="panel-title">Doc1: 28-11-2016::16:00</label>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <form>
                                    <input class="form-control" type="text" placeholder="Usuario del paciente"/>
                                    <input class="form-control" type="text" placeholder="Nombre del paciente"/>
                                    <input class="btn btn-primary form-control" type="submit" value="Agregar cita"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10) {
                dd='0'+dd
            } 

            if(mm<10) {
                mm='0'+mm
            } 
            today = yyyy+'-'+mm+'-'+dd;
            $('#date').val(today);
            $miTabla = $('#dataTables-example').DataTable({
                responsive: true,
                "ajax": {
                    "method": "POST",
                    "beforeSend": function(request) {
                        request.setRequestHeader("X-CSRF-TOKEN", "<?php echo csrf_token(); ?>");
                    },
                    "url": "/ajaxRC",
                    "data": function ( d ) {
                        d.idDoc = $('#idDoc').val();
                        d.date = $('#date').val();
                        d.disp = $('#disponible').prop("checked");
                    }
                },
                "columns":[
                    {"data":"Seleccionar"},
                    {"data":"Paciente"},
                    {"data":"Usuario"},
                    {"data":"Tipo"},
                    {"data":"Hora"}
                ]
            });

            
        });

function updateDates()
            {
                $miTabla.ajax.reload();
                console.log($miTabla.ajax.params());
                return false;
            }
    </script>

</body>

</html>
<?php/*
<div class="radio">
                                            <td><input type="radio" name="optradio"/></td>
                                        </div>*/?>