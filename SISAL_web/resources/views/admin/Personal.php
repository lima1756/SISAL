<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    use App\myClasses\Type;
    if($_GET['type']=="doctors")
    {
$valores=["usuarios.id_usuario","nombre", "apellidoPaterno","medicos.estado" ,"apellidoMaterno", "usuario", "email"];
$tabla="usuarios";
$where=[];
$join=[["medicos", "usuarios.id_usuario","medicos.id_usuario"]];
$datos = dbConnection::select($valores,$tabla,$where,$join);

$existeGet = false;
    if(isset($_GET['id']))
    {
        foreach($p as $datos)
        {
            if($p['id_usuario']==$_GET['id'])
            {
                $existeGet = true;
            }
        }
    }
    }
    elseif($_GET['type']=="recepcionist"){
$valores=["usuarios.id_usuario","nombre","apellidoPaterno", "recepcionistas.estado","apellidoMaterno", "usuario", "email"];
$tabla="usuarios";
$where=[];
$join=[["recepcionistas", "usuarios.id_usuario","recepcionistas.id_usuario"]];
$datos = dbConnection::select($valores,$tabla,$where,$join);

$existeGet = false;
    if(isset($_GET['id']))
    {
        foreach($p as $datos)
        {
            if($p['id_usuario']==$_GET['id'])
            {
                $existeGet = true;
            }
        }
    }




    }
$masInfo = dbConnection::select(["*"], "medicos", [["id_usuario", logData::getData("id_usuario")]]);

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
    <link rel='shortcut icon' href='../dataSource/img/favicon.png' type='image/x-icon'/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        label input[type="radio"] ~ i.fa.fa-circle-o{
            color: #c8c8c8;    display: inline;
        }
        label input[type="radio"] ~ i.fa.fa-dot-circle-o{
            display: none;
        }
        label input[type="radio"]:checked ~ i.fa.fa-circle-o{
            display: none;
        }
        label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
            color: #7AA3CC;    display: inline;
        }
        label:hover input[type="radio"] ~ i.fa {
        color: #7AA3CC;
        }
    </style>
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
                            <a href="#"><i class="fa fa-table fa-fw"></i>Personal<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/Personal/?type=doctors">Doctores</a>
                                </li>
                                
                                <li>
                                    <a href="/Personal/?type=recepcionist">Recepcionistas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="/medicine"><i class="fa fa-medkit fa-fw"></i> Medicina por aprobar</a>
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
                    <?php if ($_GET['type']=="doctors") { ?>
                    <h1 class="page-header">Personal: Doctores.</h1>
                    <?php }elseif ($_GET['type']=="recepcionist") {?>
                    <h1 class="page-header">Personal: Recepcionista.</h1>
                    <?php } ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <!-- BOTON DE TODOS -->
                <div class="col-lg-12 form-group">
                            <!--<button type="button" href="#table" class="btn btn-warning btn-lg" style="width:100%;" onclick="nuevo(); return false;" > Registrar Nuevo </button>-->
                            <?php if ($_GET['type']=="doctors") { ?>
                            <a href="#table" class="btn btn-primary btn-xl page-scroll"   onclick="nuevo(); return false;"  style="width:100%;">Registrar Nuevo Medico</a>
                            <?php }elseif ($_GET['type']=="recepcionist"){ ?>
                            <a href="#table" class="btn btn-primary btn-xl page-scroll"   onclick="nuevo(); return false;"  style="width:100%;">Registrar Nuevo Recepcionista</a>
                            <?php } ?>
                </div>
                <!-- LISTA DE Empleado -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Usuario</th>
                                        <th>Empleado</th>
                                        <th>Estado del empleado</th>
                                       </tr>
                                </thead>
                                <tbody>
                                <?php foreach($datos as $d): ?>
                                    <tr class="odd gradeX">
                                        <td><label class="btn active">
                                            <input type="radio" name="empleado" value="<?php echo $d['id_usuario']; ?>"id="<?php echo "radio".$d['id_usuario']?>" style="display:none"/>
                                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>
                                        </label></td>
                                        <td><?php echo $d['usuario']; ?></td>
                                        <td><?php echo $d['nombre'] . " " . $d['apellidoPaterno'] . " " . $d['apellidoMaterno']; ?></td>
                                        <td><?php if ($d['estado']=='0'){?>
                                        <button class="btn btn-danger" onclick="alta('<?php echo$d['id_usuario']?>', '<?php echo$d['nombre']?>'); ">X</button>
                                        <?php } elseif  ($d['estado']=='1'){ ?>
                                        <button class="btn btn-success" onclick="rechazar('<?php echo$d['id_usuario']?>', '<?php echo$d['nombre']?>'); ">O</button>
                                        <?php } ?>
                                        </td>     
                                <?php endforeach; ?>
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
                    <form name="formulario" id="formulario" action="/dashboard/patients" method="POST">
                        <input type="text" name="_token" id="_token" value="<?php echo csrf_token(); ?>" hidden/>
                        <div class="panel panel-default"aria-multiselectable="true" id="toda_info" hidden>
                            <div class="panel-heading">
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-warning" onclick="edicion(); return false;" type="submit" id="editar">Editar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-success" type="submit" id="aceptar" onclick="return aceptacion();" style="display:none;">Aceptar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-danger" type="submit" id="cancelar" onclick="cancelacion(); return false;" style="display:none;">Cancelar</button></span>
                                <span><h2 id="nombre_completo" name="nombre_completo">alguien</h2></span>
                            </div>
                            <section id="table" name="table">
                            </section>
                            <div id="tablist">
                                    <input type="text" name="idEmpleado" id="idEmpleado" hidden/>
                                    
                                    <!-- Desplegable información Personal--> 
                                    <div>
                                        <!--href="javascript:myToggler();"-->
                                        <a  data-toggle="collapse" role ="tab" data-target="#pInf" id="toggler" data-parent="#tablist">
                                        <div class="btn btn-primary" style="width:100%;">
                                            <h3>Información personal</h3>
                                        </div>
                                        </a>                                        
                                        <div class="panel-body collapse indent" id="pInf" >
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Usuario</label>
                                                <input class="form-control" type="text" placeholder="Usuario" id="usuario" name="usuario" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Actualizar contraseña</label>
                                                <input class="form-control" type="text" placeholder="Actualizar contraseña" id="pass" name="pass" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input class="form-control" type="text" placeholder="Nombre" id="nombre" name="nombre" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Apellido Paterno</label>
                                                <input class="form-control" type="text" placeholder="Apellido Paterno" id="apellidoPaterno" name="apellidoPaterno" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Apellido Materno</label>
                                                <input class="form-control" type="text" placeholder="Apellido Materno" id="apellidoMaterno" name="apellidoMaterno" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Domicilio</label>
                                                <input class="form-control" type="text" placeholder="Domicilio" id="domicilio" name="domicilio" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <!--Ver si esto se puede hacer dinamicamente con un select y una tabla de ciudades, estados y paises-->
                                            <div class="form-group">
                                                <label>Código Postal</label>
                                                <input class="form-control" type="number" placeholder="Código Postal" id="codigoPostal" name="codigoPostal" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Teléfono domiciliar</label>
                                                <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Teléfono oficina</label>
                                                <input class="form-control" type="number" placeholder="Teléfono oficina" id="ofTel" name="ofTel" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Correo Electrónico</label>
                                                <input class="form-control" type="email" placeholder="Correo Electrónico" id="email" name="email" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Genero</label>
                                                <select class="form-control" id="genero" name="genero" disabled>
                                                    <option value="-1">Seleccione un genero</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                </select>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>No. de Seguridad social</label>
                                                <input class="form-control" type="text" placeholder="No. de Seguridad social" id="seguroSocial" name="seguroSocial" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Fecha de nacimiento</label>
                                                <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="fechaNacimiento" name="fechaNacimiento" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Ocupación</label>
                                                <input class="form-control" type="text" placeholder="Ocupación" id="ocupacion" name="ocupacion" disabled/>
                                            </div>
                                            </td>                                           
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group" hidden>
                                                <label>Estado</label>
                                                <input class="form-control" type="text" placeholder="estado" id="estado" name="estado" disabled  />
                                            </div>
                                            </td>
                                            </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <?php if ($_GET['type']=="doctors"){ ?>
                                        <div>
                                            <div id="adicional" hidden>
                                                <a href="" data-toggle="collapse" role ="tab" data-target="#responsableInf" data-parent="#tablist">
                                                <div class="btn btn-primary" style="width:100%;" onclick="return false;">
                                                    <h4>Información Adicional Doctor</h2>
                                                </div>
                                                </a>                                        
                                                <div class="panel-body collapse indent" id="responsableInf" >
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <tr>
                                                <td>
                                                Domicilio Particular:
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Domicilio consulta particular" name="domPart" id="domPart" disabled/>
                                                </div>
                                                </td>
                                                <td>
                                                Telefono emergencias:
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Telefono de emergencias" name="telEme" id="telEme"  disabled/>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                Celular de emergencias:
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Celular de emergencias" name="celEmergencias" id="celEmergencias"  disabled/>
                                                </div>
                                                </td>
                                                <td>
                                                Correo:
                                                <div class="form-group">
                                                    <input class="form-control" type="email" placeholder="Correo Electrónico" name="correoAux" id="correoAux"  disabled/>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                Facebook:
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Facebook" name="face" id="face"  disabled/>
                                                </div>
                                                </td>
                                                <td>
                                                Twitter:
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Twitter" name="twitter" id="twitter"  disabled/>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <div class="form-group">
                                                    <label>Cedula:</label>
                                                    <input class="form-control" type="text" placeholder="cedula" id="cedula" name="cedula" disabled/>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <div class="form-group">
                                                    <label>Especialidad:</label>
                                                    <input class="form-control" type="text" placeholder="Especialidad" id="Especialidad" name="Especialidad" disabled/>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <div class="form-group">
                                                    <label>Universidad:</label>    
                                                    <input class="form-control" type="text" placeholder="Universidad" id="universidad" name="universidad"disabled/>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <label>Dias de trabajo:</label>
                                                <div class="form-group">
                                                    <input type="checkbox" id="lunes" name="lunes"  disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="lunes" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="lunes" class="btn btn-default active" id="checkbox" disabled>
                                                            Lunes
                                                        </label>
                                                    </div>
                                                    <input type="checkbox" id="martes" name="martes" disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="martes" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="martes" class="btn btn-default active" id="checkbox" disabled>
                                                            Martes
                                                        </label>
                                                    </div>
                                                    <input type="checkbox" id="miercoles" name="miercoles" disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="miercoles" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="miercoles" class="btn btn-default active" id="checkbox" disabled>
                                                            Miercoles
                                                        </label>
                                                    </div>
                                                    <input type="checkbox" id="jueves" name="jueves"  disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="jueves" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="jueves" class="btn btn-default active"  id="checkbox" disabled>
                                                            Jueves
                                                        </label>
                                                    </div>
                                                    <input type="checkbox" id="viernes" name="viernes" disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="viernes" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="viernes" class="btn btn-default active" id="checkbox" disabled>
                                                            Viernes
                                                        </label>
                                                    </div>
                                                    <input type="checkbox" id="sabado" name="sabado" disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="sabado" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="sabado" class="btn btn-default active" id="checkbox" disabled>
                                                            Sabado
                                                        </label>
                                                    </div>
                                                    <input type="checkbox" id="domingo" name="domingo" disabled hidden/>
                                                    <div class="btn-group">
                                                        <label for="domingo" class="btn btn-default" id="checkbox" disabled>
                                                            <span class="[ fa fa-check ]"></span>
                                                            <span>&nbsp</span>
                                                        </label>
                                                        <label for="domingo" class="btn btn-default active" id="checkbox" disabled>
                                                            Domingo
                                                        </label>
                                                    </div>
                                                </div>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <label>Horario de trabajo:</label>
                                                <p>Inicio:</p>
                                                <input type="time" class="form-control" name="inicio" id="inicio"  disabled/>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <p>Fin:</p>
                                                <input type="time" class="form-control" name="fin" id="fin" disabled/>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td>
                                                <label>Tiempo de consulta</label>
                                                <input class="form-control" type="text" placeholder="Tiempo" id="tiempo" name="tiempo" disabled/>
                                                </td>
                                                </tr>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php }elseif($_GET['type']=="recepcionist") {} ?>
                                </form>
                            </div>
                            <!-- /.col 12 -->   
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
    var json = 0;
    var id = 0;
    var idDoctor = 0;
    var idCita = 0;
    var csrfVal="<?php echo csrf_token(); ?>";
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "50%", "targets": 2 },
                { "width": "20%", "targets": 3 }
            ],
            "order": [[ 2, "asc" ]]
        });
        <?php if($existeGet): ?>
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            }
            })
            <?php if ($_GET['type']=="doctors") { ?>
                    $.post("/ajaxAD", { 
                'personalId': '<?php echo $_GET['id']; ?>'
            }, 
            <?php }elseif ($_GET['type']=="recepcionist") {?>
                    $.post("/ajaxAR", { 
                'personalId': '<?php echo $_GET['id']; ?>'
            },
            <?php } ?>
            

            function(data, status){
                json = JSON.parse(data);
                if(json != 0)
                {
                    $('#toda_info').show();
                    $('#adicional').show();
                    document.getElementById('toda_info').scrollIntoView();
                    $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                    recuperarInfo();
                    cancelacion();
                }
                
            });
            $('html, body').animate({
                scrollTop: $("#toda_info").offset().top
            }, 1000);
        <?php endif; ?>
    });
    $('input[type=radio][name=empleado]').on("click", function() {
        cancelacion();
        <?php foreach ($datos as $key => $d): ?>
            <?php if($key==0): ?>
                if (this.value == <?php echo $d['id_usuario'];?>) {
                    id=$('input:radio[name=empleado]:checked').val();
                }
            <?php else: ?>
                else if (this.value == <?php echo $d['id_usuario'];?>) {
                    id=$('input:radio[name=empleado]:checked').val();
                }
            <?php endif; ?>
        <?php endforeach; ?>
        
        $('#idEmpleado').val(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            }
        })
        <?php if ($_GET['type']=="doctors") { ?>
                    $.post("/ajaxAD", { 
                'personalId': id
            }, 
            <?php }elseif ($_GET['type']=="recepcionist") {?>
                    $.post("/ajaxAR", { 
                'personalId': id
            },
        <?php } ?>
        function(data, status){
            json = JSON.parse(data);
            if(json != 0)
            {
                $('#toda_info').show();
                $('#adicional').show();
                document.getElementById('toda_info').scrollIntoView();
                $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                recuperarInfo();
                cancelacion();
            }
            
        });
    });
    function cancelacion()
        {
            if(json.generales)
            {
            recuperarInfo();
            }
            $('#formulario :input').prop('disabled', true);
            $('#editar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
            $('#aceptar').prop('disabled', false);
            $('label[id="checkbox"]').attr('disabled', true);
            $('#editar').show();
            $('#cancelar').hide();
            $('#aceptar').hide();
            $('#medico').attr("disabled", false);
            $('#fechaCita').attr("disabled", false);
                
        }

    function recuperarInfo()
    {
        $('#usuario').val(json.generales.usuario);
        $('#nombre').val(json.generales.nombre);
        $('#apellidoPaterno').val(json.generales.apellidoPaterno);
        $('#apellidoMaterno').val(json.generales.apellidoMaterno);
        $('#domicilio').val(json.generales.Domicilio);
        $('#codigoPostal').val(json.generales.codigoPostal);
        $('#domTel').val(json.generales.telefonoDomiciliar);
        $('#ofTel').val(json.generales.telefonoDomiciliar);
        $('#email').val(json.generales.telefonoDomiciliar);
        if(json.generales.genero=="Masculino")
        {
            $('#genero').val("Masculino");
        }
        else if(json.generales.genero=="Femenino")
        {
            $('#genero').val("Femenino");
        }
        else
        {
            $('#genero').val("-1");
        }
        $('#seguroSocial').val(json.generales.noSeguroSocial);
        var fecha = new Date(json.generales.fechaNacimiento);
        $('#fechaNacimiento').val(json.generales.fechaNacimiento);
        var hoy = new Date();
        var edad = 0;
        if(fecha.getDate() > hoy.getDate() && fecha.getMonth() > hoy.getMonth())
        {
            edad = hoy.getFullYear() - fecha.getFullYear() + 1;
        }
        else
        {
            edad = hoy.getFullYear() - fecha.getFullYear();
        }
        $('#edad').html(edad);
        $('#ocupacion').val(json.generales.Ocupacion);
        $('#estado').val(json.adicional.estado);
        if(json.adicional)
        {
            $("#idEmpleado").val(id);
            $('#domPart').val(json.adicional.domicilio);
            $('#telEme').val(json.adicional.telefono);
            $('#celEmergencias').val(json.adicional.emergencias);
            $('#correoAux').val(json.adicional.correo);
            $('#Face').val(json.adicional.face);
            $('#twitter').val(json.adicional.tw);
            $('#cedula').val(json.adicional.cedula);
            $('#Especialidad').val(json.adicional.especialidad);
            $('#universidad').val(json.adicional.universidad);
            var horario = json.adicional.horario_trabajo;
            var lunes = horario.indexOf("l");
            var martes = horario.indexOf("m");
            var miercoles = horario.indexOf("x");
            var jueves = horario.indexOf("j");
            var viernes = horario.indexOf("v");
            var sabado = horario.indexOf("s");
            var domingo = horario.indexOf("d");
            if(lunes!=-1)
                $('#lunes').prop("checked", true);
            else
                $('#lunes').prop("checked", false);
            if(martes!=-1)
                $('#martes').prop("checked", true);
            else
                $('#martes').prop("checked", false);
            if(miercoles!=-1)
                $('#miercoles').prop("checked", true);
            else
                $('#miercoles').prop("checked", false);
            if(jueves!=-1)
                $('#jueves').prop("checked", true);
            else
                $('#jueves').prop("checked", false);
            if(viernes!=-1)
                $('#viernes').prop("checked", true);
            else
                $('#viernes').prop("checked", false);
            if(sabado!=-1)
                $('#sabado').prop("checked", true);
            else
                $('#sabado').prop("checked", false);
            if(domingo!=-1)
                $('#domingo').prop("checked", true);
            else
                $('#domingo').prop("checked", false);
            
            var match = /\(/.exec(horario);
            var inicio = 0;
            if (match) {
                inicio = match.index+1;
            }

            var match = /-/.exec(horario);
            var fin = 0;
            if (match) {
                fin = match.index-inicio
            }
            var horaInicio = horario.substr(inicio, fin);
            var match = /-/.exec(horario);
            var inicio2 = 0;
            if (match) {
                inicio2 = match.index+1;
            }

            var match = /\)/.exec(horario);
            var fin2 = 0;
            if (match) {
                fin2 = match.index-inicio2;
            }
            var horaFin = horario.substr(inicio2, fin2);
            $('#inicio').val(horaInicio);
            $('#fin').val(horaFin);
            $('#tiempo').val(json.adicional.tiempo_consulta);
            $('#domPart').val(json.adicional.domicilioConsultorio);
            $('#telEme').val(json.adicional.telEmergencias);
            $('#celEmergencias').val(json.adicional.celEmergencias);
            $('#correoAux').val(json.adicional.emailEmergencias);
            $('#face').val(json.adicional.facebook);
            $('#twitter').val(json.adicional.twitter);
            $('#cedula').val(json.adicional.cedula);
            $('#Especialidad').val(json.adicional.especialidad);
            $('#universidad').val(json.adicional.universidad);

        }
        else
        {
            
            $("#idEmpleado").val("-1");
            $('#domPart').val("");
            $('#telEme').val("");
            $('#celEmergencias').val("");
            $('#correoAux').val("");
            $('#face').val("");
            $('#twitter').val("");
            $('#cedula').val("");
            $('#Especialidad').val("");
            $('#universidad').val("");
            $('#estado').val("");
            $('#lunes').prop("checked", false);
            $('#martes').prop("checked", false);
            $('#miercoles').prop("checked", false);
            $('#jueves').prop("checked", false);
            $('#viernes').prop("checked", false);
            $('#sabado').prop("checked", false);
            $('#domingo').prop("checked", false);

            $('#inicio').val("");
            $('#fin').val("");
            $('#Tiempo').val("");
        }

    }

    function edicion()
    {
        $('#formulario :input').attr('disabled', false);
        $('#editar').prop('disabled', false);
        $('#cancelar').prop('disabled', false);
        $('#aceptar').prop('disabled', false);
        $('label[id="checkbox"]').attr('disabled', false);
        $('#editar').hide();
        $('#cancelar').show();
        $('#aceptar').show();
    }

    function aceptacion()
        {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal,
                                    },
                async: false
            })
            <?php if ($_GET['type']=="doctors"):  ?>
                $.post("/ajaxAgD",
                $('#formulario').serialize(),
            function(data, status){
                var misdatos = data;
                if(misdatos !== "undefined")
                {
                    $("#idEmpleado").val(misdatos);
                }
                $('#formulario :input').prop('disabled', true);
                $('#_token').prop('disabled', false);
                $('#editar').prop('disabled', false);
                $('#cancelar').prop('disabled', false);
                $('#aceptar').prop('disabled', false);
                $('label[id="checkbox"]').attr('disabled', true);
                $('#editar').show();
                $('#cancelar').hide();
                $('#aceptar').hide();
                $('#pass').val("");
                $('#medico').attr("disabled", false);
                $('#fechaCita').attr("disabled", false);
                location.reload(true);
            });   
                   
            <?php elseif ($_GET['type']=="recepcionist"): ?>
                $.post("/ajaxAgR",
                $('#formulario').serialize(),
            function(data, status){
                var misdatos = data;
                if(misdatos !== "undefined")
                {
                    $("#idEmpleado").val(misdatos);
                }
                $('#formulario :input').prop('disabled', true);
                $('#_token').prop('disabled', false);
                $('#editar').prop('disabled', false);
                $('#cancelar').prop('disabled', false);
                $('#aceptar').prop('disabled', false);
                $('label[id="checkbox"]').attr('disabled', true);
                $('#editar').show();
                $('#cancelar').hide();
                $('#aceptar').hide();
                $('#pass').val("");
                $('#medico').attr("disabled", false);
                $('#fechaCita').attr("disabled", false);
                location.reload(true);
            });
         <?php endif; ?>

           return false; 
            
        }

    var activo = false;
    


    function nuevo()
    {
            $('#idEmpleado').val(-1);
            $('#nombre_completo').html("Empleado: ")
            $('#usuario').val("");
            $('#nombre').val("");
            $('#apellidoPaterno').val("");
            $('#apellidoMaterno').val("");
            $('#domicilio').val("");
            $('#codigoPostal').val("");
            $('#domTel').val("");
            $('#ofTel').val("");
            $('#email').val("");
            $('#genero').val("-1");
            $('#seguroSocial').val("");
            $('#fechaNacimiento').val("");
            $('#edad').html("");
            $('#ocupacion').val("");

            $('#estado').val("1");
        
            $("#idEmpleado").val("");
            $('#domPart').val("");
            $('#telEme').val("");
            $('#celEmergencias').val("");
            $('#correoAux').val("");
            $('#face').val("");
            $('#twitter').val("");
            $('#cedula').val("");
            $('#Especialidad').val("");
            $('#universidad').val("");


            $('#lunes').prop("checked", false);
            $('#martes').prop("checked", false);
            $('#miercoles').prop("checked", false);
            $('#jueves').prop("checked", false);
            $('#viernes').prop("checked", false);
            $('#sabado').prop("checked", false);
            $('#domingo').prop("checked", false);

            $('#inicio').val("");
            $('#fin').val("");
            $('#tiempo').val("");

            $('#formulario :input').attr('disabled', false);
            $('#editar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
            $('#aceptar').prop('disabled', false);
            $('label[id="checkbox"]').attr('disabled', false);
            $('#editar').hide();
            $('#aceptar').show(); 
            $('#toda_info').show();
            <?php if ($_GET['type']=="doctors") { ?>
            $('#adicional').show();
            <?php }elseif ($_GET['type']=="recepcionist") {?>
            
            <?php } ?>
            return false;
    }
        
        function rechazar(ID, Name){
         <?php if ($_GET['type']=="doctors") { ?>
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
                url:   '/ajaxAeD',
                type:  'post',
                beforeSend: function () {
                        $('#dataTables-example').prop('action', "/Personal/?type=doctors");
                }
        });

        <?php }elseif ($_GET['type']=="recepcionist") {?>
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
                url:   '/ajaxAeR',
                type:  'post',
                beforeSend: function () {
                        $('#dataTables-example').prop('action', "/Personal/?type=recepcionist");
                }
        });
        <?php } ?>
        location.reload(true);
    }




    function alta(ID, Name){
         <?php if ($_GET['type']=="doctors") { ?>
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
                url:   '/ajaxAaD',
                type:  'post',
                beforeSend: function () {
                        $('#dataTables-example').prop('action', "/Personal/?type=doctors");
                }
        });

        <?php }elseif ($_GET['type']=="recepcionist") {?>
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
                url:   '/ajaxAaR',
                type:  'post',
                beforeSend: function () {
                        $('#dataTables-example').prop('action', "/Personal/?type=recepcionist");
                }
        });
        <?php } ?>
        location.reload(true);
    }




    </script>
    
</body>

</html>
