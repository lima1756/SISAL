<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    use App\myClasses\Type;
    date_default_timezone_set("America/Mexico_City");
    $today = date("Y-m-d") . " 00:00:00";
    $tomorrow = date("Y-m-d", strtotime('+1 day')) . " 00:00:00";
    $citasHoy = dbConnection::select(["id_usuario", "TIME(fecha_hora) AS hora", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"], "citas", 
        [["citas.fecha_hora", $today, ">"], ["citas.fecha_hora", $tomorrow, "<"]], 
        [["usuarios", "usuarios.id_usuario", "citas.id_medico"]]);
    $cantidadCitas = count($citasHoy);
    $notas = dbConnection::select(["contenido", "DATE_FORMAT(fechaHora,'%d/%m/%Y %h:%i:%s') AS fecha"], "notas", [["notas.id_usuario", logData::getData("id_usuario")]], [], "ORDER BY fechaHora DESC");
    if(Type::isPatient()):
        $meds = dbConnection::RAW("
            SELECT medicamentos.nombre, tratamiento.inicio, tratamiento.cada, tratamiento.durante, tratamiento.indicaciones 
            FROM tratamiento 
            INNER JOIN registro_clinico ON registro_clinico.id_registro = tratamiento.id_registro 
            INNER JOIN medicamentos ON medicamentos.id_medicamento = tratamiento.id_medicamento 
            WHERE tratamiento.inicio + INTERVAL tratamiento.durante HOUR > NOW()
            AND registro_clinico.id_paciente = '".logData::getData("id_usuario")."';
        ");
    elseif(Type::isInCharge()):
        $id_Usuario = dbConnection::select(['id_paciente'], 'encargados', [['id_usuario', logData::getData("id_usuario")]])[0]['id_paciente'];;
        $meds = dbConnection::RAW("
            SELECT medicamentos.nombre, tratamiento.inicio, tratamiento.cada, tratamiento.durante, tratamiento.indicaciones 
            FROM tratamiento 
            INNER JOIN registro_clinico ON registro_clinico.id_registro = tratamiento.id_registro 
            INNER JOIN medicamentos ON medicamentos.id_medicamento = tratamiento.id_medicamento 
            WHERE tratamiento.inicio + INTERVAL tratamiento.durante HOUR > NOW()
            AND registro_clinico.id_paciente = '$id_Usuario';
        ");
    endif;
    $lista=[];
    foreach($meds as $m)
    {
        $now = time();
        $m['siguiente'] = strtotime($m['inicio']);
        while($m['siguiente']<$now)
        {
            $m['siguiente']+=$m['cada']*3600;
        }
        if($m['cada']<3)
        {
            $inicial = $m;
            while($inicial['siguiente']<($now+3*3600))
            {   
                array_push($lista,$inicial);
                $inicial['siguiente']+=$inicial['cada']*3600;
            }    
        }
        else
        {
            if($m['siguiente']<($now+3*3600))
                array_push($lista,$m);
        }
    }

    function swap(&$arr, $a, $b) {
        $tmp = $arr[$a];
        $arr[$a] = $arr[$b];
        $arr[$b] = $tmp;
    }

    $size = count($lista);
    for ($i=0; $i<$size; $i++) {
        for ($j=0; $j<$size-1-$i; $j++) {
            if ($lista[$j+1]['siguiente'] < $lista[$j]['siguiente']) {
                swap($lista, $j, $j+1);
            }
        }
    }
    
    
    
    
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Paciente</title>

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
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="../dashboard/dates"><i class="fa fa-table fa-fw"></i>Mis citas</a>
                        </li>
                        <li>
                            <a href="../dashboard/doctors"><i class="fa fa-user-md fa-fw"></i> Mis médicos</a>
                        </li>
                        <li>
                            <a href="../dashboard/medicines"><i class="fa fa-medkit fa-fw"></i> Mis medicinas</a>
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
                
                <div class="col-lg-6 col-md-6 grid-item">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-medkit fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><h2>Mis medicinas</h2></div>
                                    <div></div>
                                    <div>tratamiento activo</div>
                                </div>
                            </div>
                        </div>
                        <a href="/dashboard/dates">
                            <div class="panel-footer">
                                <span class="pull-left">Ver medicamentos</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 grid-item">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-hospital-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><h2>Clínica</h2></div>
                                    <div>Información</div>
                                </div>
                            </div>
                        </div>
                        <a href="/dashboard/clinic">
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
                            <i class="fa fa-heartbeat fa-fw"></i>Proximos medicamentos a tomar
                        </div>
                        <div class="panel-body">
                            <ul class="timeline">
                                <?php $a=0; foreach($lista as $s): ?>
                                    <?php if($a%2==0): ?>
                                        <li>
                                    <?php else: ?>
                                        <li class="timeline-inverted">
                                    <?php endif; $a++; ?>
                                    <?php if((time()+600)<$s['siguiente']): ?>
                                        <div class="timeline-badge warning"><i class="fa fa-minus"></i>
                                    <?php else: ?>
                                        <div class="timeline-badge success"><i class="fa fa-check"></i>
                                    <?php endif?>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title"><?php echo $s['nombre']; ?></h4>
                                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date("H:i", $s['siguiente']); ?></small>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                                
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
                            <i class="fa fa-bell fa-fw"></i> Citas hoy:
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <?php if($cantidadCitas != 0): ?>
                                    <?php foreach($citasHoy as $cita): ?>
                                            
                                            <i class="fa fa-calendar-check-o fa-fw"></i> Doctor:  <?php echo $cita['nombre'] . " " . $cita['apellidoPaterno'] . " " . $cita['apellidoMaterno']; ?>
                                            <span class="pull-right text-muted small"><em><?php echo date("H:i",strtotime($cita['hora'])); ?></em>
                                            </span>

                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <i class="fa fa-calendar-check-o fa-fw"></i> No hay citas el día de hoy :)
                                <?php endif; ?>
                            </div>
                            <!-- /.list-group -->
                            <a href="/dashboard/dates" class="btn btn-primary btn-block">Ver todas</a>
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
    <link rel='shortcut icon' href='../dataSource/img/favicon.png' type='image/x-icon'/>
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
