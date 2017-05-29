<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    use App\myClasses\Type;

date_default_timezone_set("America/Mexico_City");
    $datos = dbConnection::select(["citas.id_medico", "usuarios.usuario", "usuarios.id_usuario","usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno", "MAX(citas.fecha_hora) as ultima"],
        "citas",
        [["citas.id_paciente", logData::getData("id_usuario")]],
        [["usuarios", "usuarios.id_usuario", "citas.id_medico"]],
        "GROUP BY citas.id_medico");
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

    <title>Paciente</title>

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
                        <li><a href="../dashboard/userProfile"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
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
                            <a href="../dashboard/dates"><i class="fa fa-table fa-fw"></i>Mis citas</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user-md fa-fw"></i> Mis médicos</a>
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
                    <h1 class="page-header">Mis médicos</h1>
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
                                        <th>Seleccionar</th>
                                        <th>Usuario</th>
                                        <th>Doctor</th>
                                        <!--<th>Ultima consulta</th>-->
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
                                    </tr>
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
                                <span><h2 id="nombre_completo" name="nombre_completo"> </h2></span>
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
                                            </table>
                                        </div>
                                    </div>
                                        
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
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>


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
                { "width": "70%", "targets": 2 }
            ],
            "order": [[ 2, "desc" ]]
        });
        <?php if($existeGet): ?>
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            }
            })
                    $.post("/ajaxPD", { 
                'personalId': '<?php echo $_GET['id']; ?>'
            }, 
            

            function(data, status){
                json = JSON.parse(data);
                if(json != 0)
                {
                    $('#toda_info').show();
                    $('#adicional').show();
                    document.getElementById('toda_info').scrollIntoView();
                    $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                    recuperarInfo();

                }
                
            });
            $('html, body').animate({
                scrollTop: $("#toda_info").offset().top
            }, 1000);
        <?php endif; ?>
    });
    $('input[type=radio][name=empleado]').on("click", function() {
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
        console.log($('#idEmpleado').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            }
        })
                $.post("/ajaxPD", { 
                'personalId': id
            }, 
        function(data, status){
            json = JSON.parse(data);
            if(json != 0)
            {
                $('#toda_info').show();
                $('#adicional').show();
                document.getElementById('toda_info').scrollIntoView();
                $('#nombre_completo').html(json.generales.nombre + " " + json.generales.apellidoPaterno + " "  + json.generales.apellidoMaterno)
                recuperarInfo();
            }
            
        });
    });

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
        if(json.adicional)
        {
            $("#idEmpleado").val(json.adicional.id_usuario);
            $('#domPart').val(json.adicional.domicilio);
            $('#telEme').val(json.adicional.telefono);
            $('#celEmergencias').val(json.adicional.emergencias);
            $('#correoAux').val(json.adicional.correo);
            $('#Face').val(json.adicional.face);
            $('#twitter').val(json.adicional.tw);
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

        }

    }

    </script>
    
</body>

</html>
