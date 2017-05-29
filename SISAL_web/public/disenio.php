<?php
    use App\myClasses\dbConnection;
    var_dump($_POST);
$regmed = $_POST['medico']; 
$idCita = $_POST['fechaCita'];  
$valores=["id_paciente", "id_medico","id_diagnostico","id_registro","fecha_hora"];
$tabla="registro_clinico";
$where=[["registro_clinico.id_registro",$idCita]];
$join=[];
$datos1 = dbConnection::select($valores,$tabla,$where,$join);

var_dump($datos1);

$v1 = $datos1[0]['id_paciente'];
$valores=["nombre", "apellidoPaterno", "apellidoMaterno","email"];
$tabla="usuarios";
$where=[["id_usuario",$v1]];
$join=[];
$datos = dbConnection::select($valores,$tabla,$where,$join);

$v11 = $datos1[0]['id_medico'];
$valores=["especialidad", "cedula", "universidad"];
$tabla="medicos";
$where=[["id_usuario",$v11]];
$join=[];
$doctor = dbConnection::select($valores,$tabla,$where,$join);

$v111 = $datos1[0]['id_medico'];
$valores=["nombre", "apellidoPaterno", "apellidoMaterno"];
$tabla="usuarios";
$where=[["id_usuario",$v111]];
$join=[];
$doctorname = dbConnection::select($valores,$tabla,$where,$join);


var_dump($datos1);

$valu = $datos1[0]['id_registro'];
$valores=["id_medicamento","durante","cada", "inicio","indicaciones"];
$tabla="tratamiento";
$where=[["id_registro",$valu]];
$join=[];
$datos3 = dbConnection::select($valores,$tabla,$where,$join);


?>

<!DOCTYPE html>
<style>
  .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
</style>
  

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Receta</title>
    <style type="text/css">

</style>
  </head>
  <body style="position:relative;width:21cm;height:29.7cm;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;color:#001028;background-color:#FFFFFF;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;font-family:Arial;font-size:12px;" >
    <div id="header" class="clearfix" style="padding-top:10px;padding-bottom:10px;padding-right:0;padding-left:0;margin-bottom:30px;" >
      <div id="logo" style="text-align:center;margin-bottom:10px;" >
        <img src="./res/CSALogo.png" style="width:250px;" >
      </div>
      <h1 style="border-top-width:1px;border-top-style:solid;border-top-color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#5D6975;color:#5D6975;font-size:2.4em;line-height:1.4em;font-weight:normal;text-align:center;margin-top:0;margin-bottom:20px;margin-right:0;margin-left:0;background-color:transparent;background-image:url(dimension.png);background-repeat:repeat;background-position:top left;background-attachment:scroll;" >Receta médica</h1>
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
      <tr>
      <td>
      <div id="project" style="float:left;" >
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Nombre: </span><?php echo $datos[0]['nombre'];?></div>
        
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Apellido Paterno: </span><?php echo $datos[0]['apellidoPaterno'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Apellido Materno: </span> <?php echo $datos[0]['apellidoMaterno'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Correo: </span> <a href="mailto:"<?php echo $datos[0]['email'];?> style="color:#5D6975;text-decoration:underline;" ><?php echo $datos[0]['email'];?></a></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Fecha: </span><?php echo $datos1[0]['fecha_hora'];?></div>
        
      </div>
      </td>
      <td>
      <div id="project" style="float:right;" >
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Doctor: </span><?php echo $doctorname[0]['nombre']. " " .$doctorname[0]['apellidoPaterno']. " " .$doctorname[0]['apellidoMaterno'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Especialidad: </span><?php echo $doctor[0]['especialidad'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Cédula: </span> <?php echo $doctor[0]['cedula'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Univeridad: </span> <?php echo $doctor[0]['universidad'];?></div>
      </div>
      </td>
      </tr> 
    </div>
    </table>
    <div>
      <table style="width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:20px;" >
        <thead>
          <tr>
            <th class="service" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Nombre Medicina:</th>
            <th class="desc" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Cada:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Durante:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Inicio de toma:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Indicaciones extra:</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($datos3 as $da): 
          $nom = dbConnection::RAW("SELECT nombre from medicamentos where id_medicamento  = '".$da['id_medicamento']."'");
          ?>
          <tr>
            <td class="service" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $nom[0];?></td>
            <td class="desc" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" ><?php echo $da['cada'];?></td>
            <td class="unit" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo $da['durante'];?></td>
            <td class="qty" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo $da['inicio'];?></td>
            <td class="total" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" ><?php echo $da['indicaciones'];?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br><br>
      <div id="notices">
        <div>Firma doctor:</div>
        <br><br>
        <div class="notice" style="color:#5D6975;font-size:1.2em;" >____________________________________________________________________________________________________________</div>
      </div>
     </div>
      <div id="company" class="clearfix" style="float:left;text-align:left;" >
        <div style="white-space:nowrap;" >                       </div>
        <div style="white-space:nowrap;" >Clinica San Antonio</div>
        <div style="white-space:nowrap;" >Av. Independencia 1748 Pte.<br /> Los Mochis, Sianaloa.</div>
        <div style="white-space:nowrap;" >(668) 812-1348</div>
        <div style="white-space:nowrap;" >(044) 6681-30-2436</div>
        <div style="white-space:nowrap;" ><a href="mailto:brucamer@gmail.com" style="color:#5D6975;text-decoration:underline;" >brucamer@gmail.com</a></div>
      </div>

    <div id="footer"style="color:#5D6975;width:100%;height:30px;position:absolute;bottom:0;border-top-width:1px;border-top-style:solid;border-top-color:#C1CED9;padding-top:8px;padding-bottom:8px;padding-right:0;padding-left:0;text-align:center;" >
      SISAL 2017.
    </div>
  </body>
</html>