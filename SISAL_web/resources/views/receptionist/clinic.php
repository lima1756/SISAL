<!DOCTYPE html>
<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $today = date("Y-m-d") . " 00:00:00";
    $tomorrow = date("Y-m-d", strtotime('+1 day')) . " 00:00:00";
    $citasHoy = dbConnection::select(["id_usuario", "TIME(fecha_hora) AS hora", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"], "citas", 
        [["citas.fecha_hora", $today, ">"], ["citas.fecha_hora", $tomorrow, "<"]], 
        [["usuarios", "usuarios.id_usuario", "citas.id_paciente"]]);
    $cantidadCitas = count($citasHoy);
    $notas = dbConnection::select(["contenido", "DATE_FORMAT(fechaHora,'%d/%m/%Y %h:%i:%s') AS fecha"], "notas", [["notas.id_usuario", logData::getData("id_usuario")]], [], "ORDER BY fechaHora DESC");

?>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recepcionista</title>

    <!-- Bootstrap Core CSS -->
    <link href="../dataSource/css/templates/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../dataSource/css/templates/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dataSource/css/templates/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../dataSource/css/templates/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../dataSource/css/templates/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                            <a href="/dashboard/dates"><i class="fa fa-table fa-fw"></i> Citas</a>
                        </li>
                        <li>
                            <a href="/dashboard/patients"><i class="fa fa-users fa-fw"></i> Pacientes</a>
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
                    <h1 class="page-header">Clínica San Antonio</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row grid">
                <div class="grid-sizer col-xs-1 col-md-1 col-lg-1"></div> <!--Aunque esta linea no parezca importante NO BORRAR-->
                
                <div>
                    <table>
                        <tr>
                        <td>
                        <img src="../res/CSALogo.png" style="width:200px;" >
                        </td>
                        <td>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14369.254933393431!2d-109.00826452783988!3d25.793221807911976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86bbbf9af1eca571%3A0x370073aeb704da08!2sClinica+San+Antonio!5e0!3m2!1ses-419!2smx!4v1495923536290" width="600" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </td>
                        </tr>
                   </table>     
                </div>
                <section class="bg-con" id="contact">
                    <div class="container">
                            

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 text-center">
                                <h2 class="section-heading">Información de contacto.</h2>
                                <hr class="primary">
                                <p>Clínica San Antonio.<br> Av. Independencia 1748 Pte. Colonia San Francisco Los Mochis, Sinaloa.</p>
                            </div>
                            <div class="col-lg-4 col-lg-offset-2 text-center">
                                <i class="fa fa-phone fa-3x sr-contact"></i>
                                <p>815-05-61<br>812-95-41</p>
                            </div>
                            <div class="col-lg-4 text-center">
                                <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                                <p><a href="mailto:your-email@your-domain.com">doctorbrunocamacho@gmail.com</a></p>
                                <p>Director General<p>
                            </div>
                        </div>
                    </div>
                </section>
               
                
                
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        <!--page-wrapper-->
    </div>

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
