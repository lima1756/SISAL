
    <?php
    use App\myClasses\dbConnection;
$true=0;   
$nombre=["nombre", "id_medicamento","aprobada"];
$tabla="medicamentos";
$where=["aprobada",$true];
$join=[];
//$datos = dbConnection::select($nombre,$tabla,$where,$join);
   $datos = dbConnection::RAW("SELECT nombre, id_medicamento, aprobada FROM `medicamentos` WHERE aprobada = 0");
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrador</title>

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
    <link rel='shortcut icon' href='/dataSource/img/favicon.png' type='image/x-icon'/>
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
                        <li><a href="/dashboard/userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                            <a href="#"><i class="fa fa-table fa-fw"></i>Personal<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/dashboard/Personal/?type=doctors">Doctores</a>
                                </li>
                                
                                <li>
                                    <a href="/dashboard/Personal/?type=recepcionist">Recepcionistas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="/dashboard/medicine"><i class="fa fa-medkit fa-fw"></i> Medicina por aprobar</a>
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
                    <h1 class="page-header">Medicina por aprobar</h1>
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
                                        <th>Aceptar</th>
                                        <th>Rechazar</th>
                                        <th>Nombre Medicamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($datos as $dato):?>
                                    <tr class="odd gradeX">
                                        <td> <button class="btn btn-success" onclick="aceptar('<?php echo $dato['id_medicamento']?>', '<?php echo$dato['nombre']?>'); ">O</button> </td>
                                        <td> <button class="btn btn-danger" onclick="rechazar('<?php echo$dato['id_medicamento']?>', '<?php echo$dato['nombre']?>'); ">X</button> </td>
                                        <td><?php echo($dato['nombre']);?></td>                                        
                                    </tr>
                                    <?php endforeach;?>
                                    
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

    var csrfVal="<?php echo csrf_token(); ?>";

    $(document).ready(function() {
        $('#dataTables-example').DataTable( {
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ medicamentos por página",
                "zeroRecords": "No se encontro nada",
                "info": "Mostrando página medicamentos _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado por _MAX_ total de medicamentos)"
            },
            "columnDefs": [
                { "width": "15%", "targets": 0 },
                { "width": "15%", "targets": 1 },
                { "width": "70%", "targets": 2 }
            ]
        } );
    } );

    function rechazar(ID, Name){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                },
                async: false
            })
        var parametros = {
                "ID" : ID,
                "nombre" : Name

        };
        $.ajax({
                data:  parametros,
                url:   '/ajaxMR',
                type:  'post',
                beforeSend: function () {
                        $('#dataTables-example').prop('action', "/dashboard/medicine");
                }
        });
        location.reload(true);
    }

function aceptar(ID, Name){
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                },
                async: false
            })
        var parametros = {
                "ID" : ID,
                "nombre" : Name

        };
        $.ajax({
                data:  parametros,
                url:   '/ajaxMA',
                type:  'post',
                beforeSend: function () {
                        $('#dataTables-example').prop('action', "/dashboard/medicine");
                }
        });
        location.reload(true);
}


    </script>

</body>

</html>