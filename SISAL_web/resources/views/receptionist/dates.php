<?php 
use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $listaDoctores = dbConnection::select(
            ['medicos.id_usuario', 'usuarios.nombre', 'usuarios.apellidoPaterno', 'usuarios.apellidoMaterno', 'usuarios.usuario'],
            "medicos",
            [],
            [['usuarios', 'medicos.id_usuario', 'usuarios.id_usuario']]);
    $pacientes = dbConnection::select(["usuarios.id_usuario", "usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"],
        "usuarios",
        [],
        [["pacientes", "usuarios.id_usuario", "pacientes.id_usuario"]]
        );
    $tipoCitas = dbConnection::select(["id", "nombre"], "tipocita");
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
    <link rel='shortcut icon' href='../dataSource/img/favicon.png' type='image/x-icon'/>
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
                                <div class="form-group" style="padding-top:15px;" id="filtros">


                                    <label class="btn">Fecha de cita: </label><input class=" btn btn-default" id="date" name="date" type="date" <?php if(isset($_GET['date'])){ $date = new DateTime($_GET['date']);echo "value=\"".$date->format('Y-m-d')."\"";}?>/>
                                    <label class="btn">Doctor: </label>
                                    <select class="btn btn-default" name="idDoc" id="idDoc" <?php if(isset($_GET['med'])){echo "value=\"" . $_GET['med'] . "\"";}?>>
                                        <?php foreach($listaDoctores as $d): ?>
                                            <option value="<?php echo $d['id_usuario'];?>" ><?php echo $d['nombre'] . " " . $d['apellidoPaterno'] . " " . $d['apellidoMaterno'];?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <input type="radio" name="opcion" id="proximasCitas" value="proximasCitas" hidden/>
                                    <div class="btn-group">
                                        <label for="proximasCitas" class="btn btn-default">
                                            <span class="fa fa-check"></span>
                                            <span>&nbsp</span>
                                        </label>
                                        <span>&nbsp</span><label for="proximasCitas" class="btn btn-default active">
                                            Ver  citas   agendadas
                                        </label>
                                    </div>                                

                                    <input type="radio" name="opcion" id="disponible" value="disponible" hidden/>
                                    <div class="btn-group">
                                        <label for="disponible" id="icoDisponible" class="btn btn-default">
                                            <span class="fa fa-check"></span>
                                            <span>&nbsp</span>
                                        </label>
                                        <span>&nbsp</span><label for="disponible" id="labelDisponible" class="btn btn-default active">
                                            Registrar nueva cita
                                        </label>
                                    </div>

                                    <input type="radio" name="opcion" id="agenda" value="agenda" hidden/>
                                    <div class="btn-group">
                                        <label for="agenda" id="icoAgenda" class="btn btn-default">
                                            <span class="fa fa-check"></span>
                                            <span>&nbsp</span>
                                        </label>
                                        <span>&nbsp</span><label for="agenda" id="labelAgenda" class="btn btn-default active">
                                            Ver agenda completa
                                        </label>
                                    </div>

                                    <button class="btn btn-primary" onclick="updateDates(); return false;">Ver citas</button>
                                </div>
                                
                            </form>
                        </div>
                        <div class="panel-body">
                        <form>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Paciente</th>
                                        <th>Celular</th>
                                        <th>Tipo</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                       
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <!--AL MOMENTO DE SELECCIONAR EL RADIO DE UNA CITA REGISTRADA, SE MUESTRAN LOS DATOS COMO SIGUE-->
                <div class="col-lg-12" id="verCita" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="panel-title" id="verCitaTitulo"></label>
                        </div>
                        <div class="panel-body">
                            <label>Usuario de paciente:</label> <p id="usuarioPaciente"></p>
                            <label>Nombre de paciente:</label> <p id="nombrePaciente"></p>
                            <label>Tipo de cita:</label> <p id="tipoCita"></p>
                            
                            <form action="#" id="cancelacionCita" name="cancelacionCita" method="POST">
                                <div class="form-group" id="divRazon" hidden>
                                    <label>Razón de cancelación</label>
                                    <textarea name="razon" id="razon" class="form-control" required></textarea>
                                </div>
                                <input type="text" id="idCitaCancelacion" name="idCitaCancelacion" hidden/>
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <button class="btn btn-danger" type="submit" id="submitCancelacion" onclick="eliminacion(); return false;">Eliminar cita</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!--AL MOMENTO DE SELECCIONAR EL RADIO DE UNA CITA NO REGISTRADA, SE PIDEN LOS DATOS COMO SIGUE-->
                <div class="col-lg-12" id="nuevaCita" hidden>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="panel-title" id="nuevaCitaTitulo">Doc1: 28-11-2016::16:00</label>
                        </div>
                        <div class="panel-body">
                            <form action="javascript:;" method="POST" id="formularioNueva">
                                <div class="form-group">
                                    <input type="checkbox" id="registrado" autocomplete="off"/>
                                    <div class="btn-group">
                                        <label for="registrado" class="btn btn-default">
                                            <span class="fa fa-check"></span>
                                            <span>&nbsp</span>
                                        </label>
                                        <label for="registrado" class="btn btn-default active">
                                            ¿Paciente nuevo?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="usuarioRegistrado">
                                    <select name="usuario" class="form-control" id="usuario" style="width: 100%" required>
                                        <?php foreach($pacientes as $p): ?>
                                            <option value="<?php  echo $p['id_usuario'] ?>"><?php  echo $p['usuario'] . " - " . $p['nombre'] . " " . $p['apellidoPaterno'] . " " . $p['apellidoMaterno'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="usuarioNuevo" hidden>
                                    <div class="form-group">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Usuario</label>
                                                        <input class="form-control" type="text" placeholder="Usuario" id="usuarioNuevo" name="usuarioNuevo" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Contraseña</label>
                                                        <input class="form-control" type="password" placeholder="Contraseña" id="pass" name="pass" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Confirmar Contraseña</label>
                                                        <input class="form-control" type="password" placeholder="Confirmar contraseña" id="pass2" name="pass2" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <input class="form-control" type="text" placeholder="Nombre" id="nombre" name="nombre" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Apellido Paterno</label>
                                                        <input class="form-control" type="text" placeholder="Apellido Paterno" id="apellidoPaterno" name="apellidoPaterno" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Apellido Materno</label>
                                                        <input class="form-control" type="text" placeholder="Apellido Materno" id="apellidoMaterno" name="apellidoMaterno" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Teléfono domiciliar</label>
                                                        <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Teléfono Celular</label>
                                                        <input class="form-control" type="number" placeholder="Teléfono oficina" id="ofTel" name="ofTel" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label>Correo Electronico</label>
                                                        <input class="form-control" type="email" placeholder="Correo Electronico" id="email" name="email" />
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="selectTipoCita" class="form-control" id="selectTipoCita" style="width: 100%" required>
                                        <?php foreach($tipoCitas as $t): ?>
                                            <option value="<?php  echo $t['id'] ?>"><?php  echo $t['nombre'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <input type="hidden" name="fecha_hora" id="fecha_hora" value="" hidden/>
                                    <input type="hidden" name="id_medico" id="id_medico" value="" hidden/>
                                    <input class="btn btn-primary" type="submit" onclick="return revision();" value="Agregar cita"/>
                                </div>
                            </form>
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
    <script src="//cdn.datatables.net/plug-ins/1.10.15/sorting/time.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dataSource/js/templates/sb-admin-2.js"></script>

    <!-- select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>     
    
    <script>
        var csrfVal = "<?php echo csrf_token(); ?>";
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
            <?php if(!isset($_GET['date'])): ?>
                $('#date').val(today);
            <?php endif; ?>
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
                        d.futuras = $('#proximasCitas').prop("checked");
                    }
                },
                "columns":[
                    {"data": function(data, type, full, meta){
                        return "<label class=\"btn active\">  <input type='radio' value='"+data.Seleccionar+"' id='"+data.Seleccionar.replace(/\s/g, '')+"' name='optradio' onclick='obtenerCita(\"" + data.Seleccionar + "\")' hidden/><i class=\"fa fa-circle-o fa-2x\"></i><i class=\"fa fa-dot-circle-o fa-2x\"></i> </label>";
                    }},
                    {"data":"Paciente"},
                    {"data":"celular"},
                    {"data":"Tipo"},
                    {"data":"Hora"}
                ],
                "columnDefs": [
                    { type: 'time-uni', "width": "10%",  "orderable": false, "targets": 0 }
                ],
                "order": [[ 4, "asc" ]]
            });
            $('#usuario').select2({
                placeholder: "Persona para la cita",
                allowClear: true,
                language: "es"
            });
            $('#usuario').val('').trigger("change");
            $('#selectTipoCita').select2({
                placeholder: "Tipo de cita que se realiza",
                allowClear: true,
                language: "es"
            });
            $('#selectTipoCita').val('').trigger("change");
            $('#idDoc').select2({
                placeholder: "Doctor de la cita",
                allowClear: true,
                language: "es"
            });
            <?php if(!isset($_GET['med'])): ?>
                $('#idDoc').val('').trigger("change");
            <?php endif; ?>
        });

        function obtenerCita(cita)
        {
            var doctor = $("#idDoc option:selected").html();
            $("#submitCancelacion").html("Eliminar cita");
            if(isNaN(cita))
            {
                var fecha = new Date(cita);
                $("#nuevaCita").show();
                $("#verCita").hide();
                $('#nuevaCitaTitulo').html(doctor + " -- " + ("0" + fecha.getDate()).slice(-2) + "/" + ("0" + (fecha.getMonth()+1)).slice(-2) + "/" + fecha.getFullYear() + " " + ("0" + fecha.getHours()).slice(-2) + ":" + ("0" + fecha.getMinutes()).slice(-2));
                $('#fecha_hora').val(cita);
                $('#id_medico').val($("#idDoc").val());
            }
            else
            {
                $("#verCita").show();
                $("#nuevaCita").hide();
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                }
                })
                $.post("/ajaxRDC", { <?php //RDC se refiere a Recepcionista obtiene Datos de Cita ?>
                    'citaId': cita
                },
                function(data, status){
                    var json = JSON.parse(data);  
                    var fecha = new Date(json.fecha_hora); 
                    $("#usuarioPaciente").html(json.usuario);
                    $("#idCitaCancelacion").val(cita);
                    $("#nombrePaciente").html(json.nombre + " " + json.apellidoPaterno + " " + json.apellidoMaterno);
                    $("#tipoCita").html(json.tipo);
                    $('#verCitaTitulo').html(json.medico.usuario + " - " + json.medico.nombre + " " + json.medico.apellidoPaterno + " " + json.medico.apellidoMaterno + " -- " + ("0" + fecha.getDate()).slice(-2) + "/" + ("0" + (fecha.getMonth()+1)).slice(-2) + "/" + fecha.getFullYear() + " " + ("0" + fecha.getHours()).slice(-2) + ":" + ("0" + fecha.getMinutes()).slice(-2));
                });
            }
        }

        function updateDates()
        {
            $miTabla.ajax.reload();
            return false;
        }

        $('#registrado').change(function() {
            if(document.getElementById('registrado').checked){
                $("#usuarioRegistrado").hide();
                $("#usuarioNuevo").show();
                $('#usuario').val('').trigger("change");
                document.getElementById("usuarioNuevo").required = true;
                document.getElementById("pass").required  = true;
                document.getElementById("pass2").required = true;
                document.getElementById("nombre").required = true;
                document.getElementById("apellidoPaterno").required = true;
                document.getElementById("apellidoMaterno").required = true;
                document.getElementById("domTel").required = true;
                document.getElementById("ofTel").required = true;
                document.getElementById("usuario").required = false;
            }
            else
            {
                $("#nombreRealNuevo").val("");
                $("#usuarioNuevo").hide();
                $("#usuarioRegistrado").show();
                document.getElementById("usuarioNuevo").required = false;
                document.getElementById("pass").required  = false;
                document.getElementById("pass2").required = false;
                document.getElementById("nombre").required = false;
                document.getElementById("apellidoPaterno").required = false;
                document.getElementById("apellidoMaterno").required = false;
                document.getElementById("domTel").required = false;
                document.getElementById("ofTel").required = false;
                document.getElementById("usuario").required = true;
            }
        });

        $(document).ready(function() {
            $('input[type=radio][name=opcion]').change(function() {
                if (this.value == 'agenda') {
                    alert("agenda");
                }
                else if (this.value == 'disponible') {
                    alert("disponible");
                }
                else if (this.value == 'proximasCitas') {
                    alert("proximasCitas");
                }
            });
        });

        function eliminacion(){
            if($("#submitCancelacion").html()=="Eliminar cita")
            {
                $("#submitCancelacion").html("Confirmar eliminacion");
                $("#divRazon").show();
            }
            else
            {
                document.getElementById("cancelacionCita").action="/eliminarCita";
                $("#cancelacionCita").send();
            }
        }

        function revision()
        {
            if($('#formularioNueva')[0].checkValidity() && validatePasswordUser())
            {
                $('#formularioNueva').prop('action', "/nuevaCita");
            }
            return true;
        }

        function validatePasswordUser(){
        var password = document.getElementById("pass");
        var confirm_password = document.getElementById("pass2");
        console.log(password.value);
        console.log(confirm_password.value);
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("No coinciden contraseñas");
            return false;
        } else {
            confirm_password.setCustomValidity('');
            return true;
        }
    }
    </script>

</body>

</html>