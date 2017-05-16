<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $pacientes = dbConnection::select(["usuarios.id_usuario", "usuarios.usuario", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"],
        "usuarios",
        [],
        [["pacientes", "usuarios.id_usuario", "pacientes.id_usuario"]]
        );
    $existeGet = false;
    if(isset($_GET['id']))
    {
        foreach($pacientes as $p)
        {
            if($p['id_usuario']==$_GET['id'])
            {
                $existeGet = true;
            }
        }
    }
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
                                    <a href="Personal/?type=doctors">Doctores</a>
                                </li>
                                
                                <li>
                                    <a href="Personal/?type=recepcionist">Recepcionistas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="registerPersonal"><i class="fa fa-edit fa-fw"></i> Registrar Personal</a>
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
                    <h1 class="page-header">Registrar Empleado</h1>
                </div>
                <div class="form-group">
                            <button type="submit" class="btn btn-warning">Guardar</button>
                            <button type="reset" class="btn btn-select">Reiniciar</button> 
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

                         <div class="form-group">
                            <textarea class="textarea50" placeholder="Nombre:" id="nombre" name="nombre" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Apellido paterno:" id="Ap" name="Ap" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                        <div class="form-group">
                            <textarea class="textarea50" placeholder="Apellido materno:" id="Am" name="Am" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Usuario:" id="usuario" name="usuario" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                        <div class="form-group">
                            <textarea class="textarea50" placeholder="Contraseña:" id="pass" name="pass" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Correo:" id="email" name="email" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                        </div>
                        
                         <div class="form-group">
                            <textarea class="textarea50" placeholder="Domicilio:" id="dom" name="dom" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Municipio:" id="municipio" name="municipio" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                         <div class="form-group">
                            <textarea class="textarea50" placeholder="CP:" id="cp" name="cp" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Telefono:" id="tel" name="tel" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                        <div class="form-group">
                            <textarea class="textarea50" placeholder="Celular:" id="cel" name="cel" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Genero:" id="genero" name="genero" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                        <div class="form-group">
                            <textarea class="textarea50" placeholder="N. Social:" id="ns" name="ns" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Fecha nacimiento:" id="fn" name="fn" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                         <div class="form-group">
                            <textarea class="textarea50" placeholder="Ocupacion:" id="ocupacion" name="ocupacion" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                            <span>&nbsp</span>
                            <textarea class="textarea50" placeholder="Puesto:" id="puesto" name="puesto" rows="1"  required style="height: 30px; width: 38%;"></textarea>
                         </div>
                        <div class="form-group">
                             <input type="checkbox" name="miDoctor" id="miDoctor" autocomplete="off" onClick="myToggler(); return false;" disabled />
                            <div class="btn-group"> 
                                        <label for="miDoctor" class="btn btn-default" id="checkDoctor" onClick="myToggler(); return false;">                                                       
                                         <span class="[ fa fa-check ]"></span>
                                            <span>&nbsp</span>
                                         </label>
                                         <label for="miDoctor" class="btn btn-default" id="labelDoctor" onClick="myToggler(); return false;">
                                               ¿Esta cuenta es doctor?
                                         </label>
                             </div>
                        </div>
                            <input type="number" name="idDoctor" id="idDoctor" hidden/>

                        <!--INFORMACIóN DOCTOR -->
                                            <div id="doctor" hidden>
                                                <!--<a href="#" data-toggle="collapse" role ="tab" data-target="#doctorInf" data-parent="#tablist">
                                                <div class="panel-heading">
                                                    <h4>Información Adicional</h2>
                                                </div>-->

                                                <a href="#doctorInf" data-toggle="collapse" role ="tab" data-target="#doctorInf" data-parent="#tablist">
                                                <span>&nbsp</span><span>&nbsp</span>
                                                <span>&nbsp</span><span>&nbsp</span>
                                                <div class="btn btn-primary" style="width:80%;">
                                                    <h4>Información Adicional</h4>
                                                </div>                                    

                                                </a>                                        
                                                <div class="panel-body collapse indent" id="doctorInf" >
                                                    <div class="form-group">
                                                        <label>Domicilio Consultorio Particula</label>
                                                        <input class="form-control" type="text" placeholder="domicilioConsultorio" id="domicilioConsultorio" name="domicilioConsultorio" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Telefono Emergencias</label>
                                                        <input class="form-control" type="text" placeholder="Telefono Emergencia" id="TelEme" name="TelEme" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Celular Emergencias</label>
                                                        <input class="form-control" type="text" placeholder="Celular" id="CelEme" name="CelEme" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                         <label>Email Emergencias</label>
                                                        <input class="form-control" type="email" placeholder="Email" id="EmailEme" name="EmailEme" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Facebook</label>
                                                        <input class="form-control" type="text" placeholder="Facebook" id="Face" name="Face" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Twitter</label>
                                                        <input class="form-control" type="text" placeholder="Twitter" id="Tw" name="TW" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Horario</label>
                                                        <input class="form-control" type="text" placeholder="Horario" name="Horario" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tiempo de consulta en minutos</label>
                                                        <input class="form-control" type="number" placeholder="Minutos" id="Tiempo" name="Tiempo" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cédula</label>
                                                        <input class="form-control" type="number" placeholder="Cédula Profesional" id="Ced" name="Ced" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Especialidad</label>
                                                        <input class="form-control" type="text" placeholder="Especialidad" id="Esp" name="Esp" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Especialidad</label>
                                                        <input class="form-control" type="text" placeholder="Universidad" id="uni" name="uni" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control" id="responsableGenero" name="responsableGenero" disabled>
                                                            <option value="-1">Seleccione un genero</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Femenino">Femenino</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="No. de Seguridad social" id="responsableSeguroSocial" name="responsableSeguroSocial" disabled/>
                                                    </div>
                                                    <?php /*<div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Lugar de nacimiento" id="lugarNacimiento" name="lugarNacimiento" disabled/>
                                                    </div> */?>
                                                    <div class="form-group">
                                                        <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="responsableFechaNacimiento" name="responsableFechaNacimiento" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                    <!--CALCULAR AQUI LA EDAD--><label class="form-control" id="responsableEdad">xy años</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Ocupación" id="responsableOcupacion" name="responsableOcupacion" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                            
                          <!-- FIN Doctor-->       
        </div>
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

    <!-- Custom Theme JavaScript -->
    <script src="../../dataSource/js/templates/sb-admin-2.js"></script>

</body>


<script>
    var json = 0;
    var id = 0;
    var idDoctor = 0;
    var idCita = 0;
    var csrfVal="<?php echo csrf_token(); ?>";
    $(document).ready(function() {
        
        <?php if($existeGet): ?>
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            }
            })
            $.post("/ajaxRP", { <?php //RP se refiere a Recepcionista-Patients ?>
                'patientId': '<?php echo $_GET['id']; ?>'
            },
            function(data, status){
                json = JSON.parse(data);
                if(json != 0)
                {
                    $('#toda_info').show();
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
    $('input[type=radio][name=paciente]').on("click", function() {
        cancelacion();
        <?php foreach ($pacientes as $key => $p): ?>
            <?php if($key==0): ?>
                if (this.value == <?php echo $p['id_usuario'];?>) {
                    id=$('input:radio[name=paciente]:checked').val();
                }
            <?php else: ?>
                else if (this.value == <?php echo $p['id_usuario'];?>) {
                    id=$('input:radio[name=paciente]:checked').val();
                }
            <?php endif; ?>
        <?php endforeach; ?>
        $('#idPaciente').val(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            }
        })
        $.post("/ajaxRP", { <?php //RP se refiere a Recepcionista-Patients ?>
            'patientId': id
        },
        function(data, status){
            json = JSON.parse(data);
            if(json != 0)
            {
                $('#toda_info').show();
                
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
        if(json.encargados)
        {
            $("#responsable").show();
            $("#miDoctor").prop("checked", true);
            $("#idResponsable").val(json.encargados.id_usuario);
            $('#responsableUsuario').val(json.encargados.usuario);
            $('#responsableNombre').val(json.encargados.nombre);
            $('#responsableApellidoPaterno').val(json.encargados.apellidoPaterno);
            $('#responsableApellidoMaterno').val(json.encargados.apellidoMaterno);
            $('#responsableDomicilio').val(json.encargados.Domicilio);
            $('#responsableCodigoPostal').val(json.encargados.codigoPostal);
            $('#responsableDomTel').val(json.encargados.telefonoDomiciliar);
            $('#responsableOfTel').val(json.encargados.telefonoDomiciliar);
            $('#responsableEmail').val(json.encargados.telefonoDomiciliar);
            if(json.encargados.genero=="Masculino")
            {
                $('#responsableGenero').val("Masculino");
            }
            else if(json.encargados.genero=="Femenino")
            {
                $('#responsableGenero').val("Femenino");
            }
            else
            {
                $('#responsableGenero').val("-1");
            }
            $('#responsableSeguroSocial').val(json.encargados.noSeguroSocial);
            var fecha = new Date(json.encargados.fechaNacimiento);
            $('#responsableFechaNacimiento').val(json.encargados.fechaNacimiento);
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
            $('#responsableEdad').html(edad);
            $('#responsableOcupacion').val(json.encargados.Ocupacion);
        }
        else
        {
            $("#responsable").hide();
            $("#miDoctor").prop("checked", false);
            $("#idResponsable").val("");
            $('#usuarioResponsable').val("");
            $('#responsableNombre').val("");
            $('#responsableApellidoPaterno').val("");
            $('#responsableApellidoMaterno').val("");
            $('#responsableDomicilio').val("");
            $('#responsableCodigoPostal').val("");
            $('#responsableDomTel').val("");
            $('#responsableOfTel').val("");
            $('#responsableEmail').val("");
            $('#responsableGenero').val("-1");
            $('#responsableSeguroSocial').val("");
            $('#responsableFechaNacimiento').val("");
            $('#responsableEdad').html("");
            $('#responsableOcupacion').val("");
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
                    'X-CSRF-TOKEN': csrfVal
                },
                async: false
            })
            $.post("/ajaxRgP",
                $('#formulario').serialize(),
            function(data, status){
                var misdatos = data;
                if(misdatos !== "undefined")
                {
                    $("#idPaciente").val(misdatos);
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
                $('#formulario').prop('action', "/dashboard/patients?id=" + $("#idPaciente").val());
            });
            
        }

    var activo = false;
    function myToggler()
    {
        if(!activo)
        {
            document.getElementById("doctor").hidden=false;
            $('html, body').animate({
                scrollTop: $("#doctor").offset().top
            }, 1000);
            activo = true;
            
        }
        else
        {
            activo= false;
            document.getElementById("doctor").hidden=true;
        }
    }

    function myToggler2()
    {
        if(!activo)
        {
            $('html, body').animate({
                scrollTop: $("#doctorInf").offset().top
            }, 1000);
            activo = true;
        }
        else
        {
            activo= false;
        }
    }

    $("#miDoctor").change(function() {
        if(document.getElementById('miDoctor').checked)
        {
            $("#doctorInf").show();   
        }
        else
        {
            $("#doctorInf").hide();
        }
    });

    function nuevo()
    {
        $('#idPaciente').val(-1);
        $('#nombre_completo').html("Nuevo empleado: ")
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
        $('#edad').html("");
        $('#ocupacion').val("");
        $("#responsable").hide();
        $("#miDoctor").prop("checked", false);
        $("#idResponsable").val("");
        $('#usuarioResponsable').val("");
        $('#responsableNombre').val("");
        $('#responsableApellidoPaterno').val("");
        $('#responsableApellidoMaterno').val("");
        $('#responsableDomicilio').val("");
        $('#responsableCodigoPostal').val("");
        $('#responsableDomTel').val("");
        $('#responsableOfTel').val("");
        $('#responsableEmail').val("");
        $('#responsableGenero').val("-1");
        $('#responsableSeguroSocial').val("");
        $('#responsableFechaNacimiento').val("");
        $('#responsableEdad').html("");
        $('#responsableOcupacion').val("");  

        $('#formulario :input').attr('disabled', false);
        $('#editar').prop('disabled', false);
        $('#cancelar').prop('disabled', false);
        $('#aceptar').prop('disabled', false);
        $('label[id="checkbox"]').attr('disabled', false);
        $('#editar').hide();
        $('#aceptar').show(); 
        $('#toda_info').show();
        return false;
    }
    </script>




</html>
