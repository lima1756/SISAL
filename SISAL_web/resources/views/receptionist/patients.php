<?php
    use App\myClasses\dbConnection;
    use App\myClasses\logData;
    date_default_timezone_set("America/Mexico_City");
    $pacientes = dbConnection::select(["usuarios.id_usuario", "usuarios.telefonoDomiciliar as tel", "usuarios.telefonoCelular as cel", "usuarios.nombre", "usuarios.apellidoPaterno", "usuarios.apellidoMaterno"],
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
                            <a href="../dashboard/dates"><i class="fa fa-table fa-fw"></i> Citas</a>
                        </li>
                        <li>
                            <a href="../dashboard/patients"><i class="fa fa-users fa-fw"></i> Pacientes</a>
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
                <div class="col-lg-12 form-group">
                            <!--<button type="button" href="#table" class="btn btn-warning btn-lg" style="width:100%;" onclick="nuevo(); return false;" > Registrar Nuevo Paciente</button>-->
                            <a href="#table" class="btn btn-primary btn-xl page-scroll"   onclick="nuevo(); return false;"  style="width:100%;">Registrar Nuevo Paciente</a>
                </div>
                <!-- LISTA DE PACIENTES -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Paciente</th>
                                        <th>Telefono</th>
                                        <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($pacientes as $p): ?>
                                    <tr class="odd gradeX">
                                        <td><label class="btn active">
                                            <input type="radio" name="paciente" value="<?php echo $p['id_usuario']; ?>"id="<?php echo "radio".$p['id_usuario']?>" style="display:none"/>
                                            <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>
                                        </label></td>
                                        <td><?php echo $p['nombre'] . " " . $p['apellidoPaterno'] . " " . $p['apellidoMaterno']; ?></td>
                                        <td><?php echo $p['tel']; ?></td>
                                        <td><?php echo $p['cel']; ?></td>
                                        
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
                    <form name="formulario" id="formulario" action="javascript:;" method="POST">
                        <input type="text" name="_token" id="_token" value="<?php echo csrf_token(); ?>" hidden/>
                        <div class="panel panel-default"aria-multiselectable="true" id="toda_info" hidden>
                            <div class="panel-heading">
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-warning" onclick="edicion(); return false;" type="submit" id="editar">Editar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-success" type="submit" id="aceptar" onclick="return aceptacion(); " style="display:none;">Aceptar</button></span>
                                <span style="float:right; padding-top:10px;"><button class="btn btn-lg btn-danger" type="submit" id="cancelar" onclick="cancelacion(); return false;" style="display:none;">Cancelar</button></span>
                                <span><h2 id="nombre_completo" name="nombre_completo">alguien</h2></span>
                            </div>
                            <section id="table" name="table">
                            </section>
                            <div id="tablist">
                                    <input type="text" name="idPaciente" id="idPaciente" hidden/>
                                    
                                    <!-- Desplegable información Personal--> 
                                    <div>
                                        <a href="javascript:myToggler();" data-toggle="collapse" role ="tab" data-target="#pInf" id="toggler" data-parent="#tablist">
                                        <div class="btn btn-primary" style="width:100%;">
                                            <h3>Información personal</h3>
                                        </div>
                                        </a>                                        
                                        <div class="panel-body collapse indent" id="pInf" >
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <div id="errorUsuario" class="alert alert-danger" hidden>Usuario existente, porfavor use otro</div>
                                                <label>Usuario</label>
                                                <input class="form-control" type="text" placeholder="Usuario" id="usuario" name="usuario" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Actualizar contraseña</label>
                                                <input class="form-control" type="text" placeholder="Actualizar contraseña" id="pass" name="pass" min="6" disabled/>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Confirmar contraseña</label>
                                                <input class="form-control" type="text" placeholder="Actualizar contraseña" id="pass2" name="pass2" disabled/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input class="form-control" type="text" placeholder="Nombre" id="nombre" name="nombre" disabled required/>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Apellido Paterno</label>
                                                <input class="form-control" type="text" placeholder="Apellido Paterno" id="apellidoPaterno" name="apellidoPaterno" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Apellido Materno</label>
                                                <input class="form-control" type="text" placeholder="Apellido Materno" id="apellidoMaterno" name="apellidoMaterno" disabled required/>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Domicilio</label>
                                                <input class="form-control" type="text" placeholder="Domicilio" id="domicilio" name="domicilio" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Ciudad</label>
                                                <input class="form-control" type="text" placeholder="Ciudad" id="ciudad" name="ciudad" disabled required/>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <input class="form-control" type="text" placeholder="Estado" id="estado" name="estado" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Código Postal</label>
                                                <input class="form-control" type="number" placeholder="Código Postal" id="codigoPostal" name="codigoPostal" disabled required/>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Teléfono domiciliar</label>
                                                <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="domTel" name="domTel" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Teléfono oficina</label>
                                                <input class="form-control" type="number" placeholder="Teléfono oficina" id="ofTel" name="ofTel" disabled required/>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <div id="errorEmail" class="alert alert-danger" hidden>Email existente, porfavor use otro</div>
                                                <label>Correo Electrónico</label>
                                                <input class="form-control" type="email" placeholder="Correo Electrónico" id="email" name="email" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Genero</label>
                                                <select class="form-control" id="genero" name="genero" disabled required>
                                                    <option value="-1">Seleccione un genero</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                </select>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>No. de Seguridad social</label>
                                                <input class="form-control" type="text" placeholder="No. de Seguridad social" id="seguroSocial" name="seguroSocial" disabled required/>
                                            </div>
                                            </td>
                                            <td>
                                            <div class="form-group">
                                                <label>Fecha de nacimiento</label>
                                                <input class="form-control" type="date" placeholder="Fecha de nacimiento" id="fechaNacimiento" name="fechaNacimiento" disabled required/>
                                            </div>
                                            </td>
                                            
                                            </tr>
                                            <tr>
                                            <td>
                                            <div class="form-group">
                                                <label>Ocupación</label>
                                                <input class="form-control" type="text" placeholder="Ocupación" id="ocupacion" name="ocupacion" disabled required/>
                                            </div>
                                            </td>
                                            </tr>
                                            </table>


                                            <div class="form-group" id="btnResponsable">
                                                <input type="checkbox" name="miResponsable" id="miResponsable" autocomplete="off" disabled />
                                                <div class="btn-group"> 
                                                    <label for="miResponsable" class="btn btn-default" id="checkResponsable">
                                                        <span class="[ fa fa-check ]"></span>
                                                        <span>&nbsp</span>
                                                    </label>
                                                    <label for="miResponsable" class="btn btn-default" id="labelResponsable">
                                                        ¿Cuenta con algun responsable?
                                                    </label>
                                                </div>
                                            </div>


                                            <input type="number" name="idResponsable" id="idResponsable" hidden/>
                                        </div>
                                        <!--INFORMACIóN RESPONSABLE -->
                                        <div>
                                            <div id="responsable" hidden>
                                                <a href="javascript:myToggler2();" data-toggle="collapse" role ="tab" data-target="#responsableInf" data-parent="#tablist">
                                                <div class="btn btn-primary" style="width:80%;">
                                                    <h4>Información Responsable</h2>
                                                </div>
                                                </a>                                        
                                                <div class="panel-body collapse indent" id="responsableInf" >

                                                    <div class="form-group">
                                                        <div id="errorUsuarioResponsable" class="alert alert-danger" hidden>Usuario existente, porfavor use otro</div>
                                                        <label>Usuario</label>
                                                        <input class="form-control" type="text" placeholder="Usuario" id="responsableUsuario" name="responsableUsuario" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Actualizar contraseña</label>
                                                        <input class="form-control" type="text" placeholder="Actualizar contraseña" id="responsablePass" name="responsablePass" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirmar contraseña</label>
                                                        <input class="form-control" type="text" placeholder="Confirmar contraseña" id="responsablePass2" name="responsablePass2" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        
                                                        <input class="form-control" type="text" placeholder="Nombre" id="responsableNombre" name="responsableNombre" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Apellido Paterno" id="responsableApellidoPaterno" name="responsableApellidoPaterno" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Apellido Materno" id="responsableApellidoMaterno" name="responsableApellidoMaterno" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Domicilio" id="responsableDomicilio" name="responsableDomicilio" disabled/>
                                                    </div>
                                                    <!--Ver si esto se puede hacer dinamicamente con un select y una tabla de ciudades, estados y paises-->
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Estado" name="responsableEstado" id="responsableEstado" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Ciudad" name="responsableCiudad" id="responsableCiudad" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="number" placeholder="Código Postal" id="responsableCodigoPostal" name="responsableCodigoPostal" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="number" placeholder="Teléfono domiciliar" id="responsableDomTel" name="responsableDomTel" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" type="number" placeholder="Teléfono oficina" id="responsableOfTel" name="responsableOfTel" disabled/>
                                                    </div>
                                                    <div class="form-group">
                                                        <div id="errorEmailResponsable" class="alert alert-danger" hidden>Email existente, porfavor use otro</div>
                                                        <input class="form-control" type="email" placeholder="Correo Electrónico" id="responsableEmail" name="responsableEmail" disabled/>
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

                                        <!-- FIN RESPONSABLE-->
                                    </div>
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
                { "width": "10%",  "orderable": false, "targets": 0 },
                { "width": "60%", "targets": 1 },
                { "width": "15%", "targets": 2 },
                { "width": "15%", "targets": 3 }
            ],
            "order": [[ 1, "asc" ]]
        });
        $(document).ready(function() {
    });
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
                
                $('html, body').animate({
                    scrollTop: $("#toda_info").offset().top
                }, 1000);
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
                existeResponsable();
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
        $('#ciudad').val(json.generales.ciudad);
        $('#estado').val(json.generales.estado);
        $('#ofTel').val(json.generales.telefonoCelular);
        $('#email').val(json.generales.email);
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
        $("#btnResponsable").hide();
        if(json.encargados)
        {
            $("#responsable").show();
            $("#miResponsable").prop("checked", true);
            $("#idResponsable").val(json.encargados.id_usuario);
            $('#responsableUsuario').val(json.encargados.usuario);
            $('#responsableNombre').val(json.encargados.nombre);
            $('#responsableApellidoPaterno').val(json.encargados.apellidoPaterno);
            $('#responsableApellidoMaterno').val(json.encargados.apellidoMaterno);
            $('#responsableDomicilio').val(json.encargados.Domicilio);
            $('#responsableCiudad').val(json.encargados.ciudad);
            $('#responsableEstado').val(json.encargados.estado);
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
            $("#miResponsable").prop("checked", false);
            $("#idResponsable").val("");
            $('#responsableUsuario').val("");
            $('#responsableNombre').val("");
            $('#responsableApellidoPaterno').val("");
            $('#responsableApellidoMaterno').val("");
            $('#responsableDomicilio').val("");
            $('#responsableCodigoPostal').val("");
            $('#responsableDomTel').val("");
            $('#responsableOfTel').val("");
            $('#responsableEmail').val("");
            $('#responsableCiudad').val("");
            $('#responsableEstado').val("");
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
        $("#btnResponsable").show();
        document.getElementById('pass').required = false;
    }

    function aceptacion()
        {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfVal
                },
                async: false
            })
            if(validateUser($("#usuario").val()) || $("#idPaciente").val!="")
            {
                $("#errorUsuario").hide();
                if(validateEmail($("#email").val()) || $("#idPaciente").val!="")
                {
                    $("#errorEmail").hide();
                    if(validateUser($("#responsableUsuario").val()) || $("#idResponsable").val!="")
                    {
                        $("#errorUsuarioResponsable").hide();
                        if(validateEmail($("#responsableEmail").val()) || $("#idResponsable").val!="")
                        {
                            $("#errorEmailResponsable").hide();
                            if($('#formulario')[0].checkValidity() && validatePasswordUser() && validatePasswordResponsable())
                            {
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
                                    return true;
                                });
                            }
                            else
                            {
                                return true;
                            }
                        }
                        else
                        {
                            $("#errorEmailResponsable").show();
                        }
                    }
                    else
                    {
                        $("#errorUsuarioResponsable").show();
                    }
                    
                }
                else
                {
                    $("#errorEmail").show();
                }
            }
            else
            {
                $("#errorUsuario").show();
            }
            
            
            
            
        }

    var activo = false;
    function myToggler()
    {
        if(!activo)
        {
            $('html, body').animate({
                scrollTop: $("#pInf").offset().top
            }, 1000);
            activo = true;
        }
        else
        {
            activo= false;
        }
    }

    function myToggler2()
    {
        if(!activo)
        {
            $('html, body').animate({
                scrollTop: $("#responsableInf").offset().top
            }, 1000);
            activo = true;
        }
        else
        {
            activo= false;
        }
    }

    $("#miResponsable").change(function() {
        existeResponsable()
    });

    function nuevo()
    {

        

        $('#idPaciente').val(-1);
        $('#nombre_completo').html("Nuevo paciente: ")
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
        $("#miResponsable").prop("checked", false);
        $("#idResponsable").val("");
        $('#responsableUsuario').val("");
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
        document.getElementById('pass').required = true;

        $('#formulario :input').attr('disabled', false);
        $('#editar').prop('disabled', false);
        $('#cancelar').prop('disabled', false);
        $('#aceptar').prop('disabled', false);
        $('label[id="checkbox"]').attr('disabled', false);
        $('#editar').hide();
        $('#aceptar').show(); 
        $('#toda_info').show();
        $('html, body').animate({
            scrollTop: $("#toda_info").offset().top
        }, 1000);
        $("#btnResponsable").show();
        return false;
        
    }

    function existeResponsable()
    {
        if(document.getElementById('miResponsable').checked)
        {
            $("#responsable").show();
            document.getElementById('responsableUsuario').required = true;
            document.getElementById('responsableNombre').required = true;
            document.getElementById('responsableApellidoPaterno').required = true;
            document.getElementById('responsableApellidoMaterno').required = true;
            document.getElementById('responsableDomicilio').required = true;
            document.getElementById('responsableCodigoPostal').required = true;
            document.getElementById('responsableDomTel').required = true;
            document.getElementById('responsableOfTel').required = true;
            document.getElementById('responsableEmail').required = true;
            document.getElementById('responsableCiudad').required = true;
            document.getElementById('responsableEstado').required = true;
            document.getElementById('responsableGenero').required = true;
            document.getElementById('responsableSeguroSocial').required = true;
            document.getElementById('responsableFechaNacimiento').required = true;
            document.getElementById('responsableEdad').required = true;
            document.getElementById('responsableOcupacion').required = true;
            if($("#idResponsable").val()=="")
            {
                document.getElementById('responsablePass').required = true;
                document.getElementById('responsablePass2').required = true;
            }
        }
        else
        {
            $("#responsable").hide();
            document.getElementById('responsableUsuario').required = false;
            document.getElementById('responsableNombre').required = false;
            document.getElementById('responsableApellidoPaterno').required = false;
            document.getElementById('responsableApellidoMaterno').required = false;
            document.getElementById('responsableDomicilio').required = false;
            document.getElementById('responsableCodigoPostal').required = false;
            document.getElementById('responsableDomTel').required = false;
            document.getElementById('responsableOfTel').required = false;
            document.getElementById('responsableEmail').required = false;
            document.getElementById('responsableCiudad').required = false;
            document.getElementById('responsableEstado').required = false;
            document.getElementById('responsableGenero').required = false;
            document.getElementById('responsableSeguroSocial').required = false;
            document.getElementById('responsableFechaNacimiento').required = false;
            document.getElementById('responsableEdad').required = false;
            document.getElementById('responsableOcupacion').required = false;
            document.getElementById('responsablePass').required = false;
            document.getElementById('responsablePass2').required = false;
        }
    }

    function validatePasswordUser(){
        var password = document.getElementById("pass");
        var confirm_password = document.getElementById("pass2");
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("No coinciden contraseñas");
            return false;
        } else {
            confirm_password.setCustomValidity('');
            return true;
        }
    }

    function validatePasswordResponsable(){
        var password = document.getElementById("responsablePass");
        var confirm_password = document.getElementById("responsablePass2");
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
            return false;
        } else {
            confirm_password.setCustomValidity('');
            return true;
        }
    }

    function validateUser(user)
    {
        var regresar = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            },
            async: false
            
        });
        $.post("/ajaxCU",
            {'user': user},
            function(data, status){
                json = JSON.parse(data);
                regresar = json.ok;
            }
        );
        return regresar;
    }

    function validateEmail(email)
    {
        console.log("email");
        var regresar = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfVal
            },
            async: false
            
        });
        $.post("/ajaxCE",
            { 'email': email},
            function(data, status){
                json = JSON.parse(data);
                regresar = json.ok;
            }
        );
        return regresar;
    }
    </script>
    
</body>

</html>
