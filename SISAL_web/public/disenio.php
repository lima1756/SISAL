<?php
    use App\myClasses\dbConnection;
    var_dump($_POST);
$regmed = $_POST['medico']; 
$idCita = $_POST['fechaCita'];  
$valores=["id_paciente", "id_diagnostico","fecha_hora"];
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
        <img src="./res/LogoMed.png" style="width:90px;" >
      </div>
      <h1 style="border-top-width:1px;border-top-style:solid;border-top-color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#5D6975;color:#5D6975;font-size:2.4em;line-height:1.4em;font-weight:normal;text-align:center;margin-top:0;margin-bottom:20px;margin-right:0;margin-left:0;background-color:transparent;background-image:url(dimension.png);background-repeat:repeat;background-position:top left;background-attachment:scroll;" >Receta médica</h1>
      
      <div id="project" style="float:left;" >
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Nombre: </span><?php echo $datos[0]['nombre'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Apellido Paterno: </span><?php echo $datos[0]['apellidoPaterno'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Apellido Materno: </span> <?php echo $datos[0]['apellidoMaterno'];?></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Correo: </span> <a href="mailto:"<?php echo $datos[0]['email'];?> style="color:#5D6975;text-decoration:underline;" ><?php echo $datos[0]['email'];?></a></div>
        <div style="white-space:nowrap;" ><span style="color:#5D6975;text-align:right;width:52px;margin-right:10px;display:inline-block;font-size:0.8em;" >Fecha: </span><?php echo $datos1[0]['fecha_hora'];?></div>
        
      </div>
    </div>
    <div>
      <table style="width:100%;border-collapse:collapse;border-spacing:0;margin-bottom:20px;" >
        <thead>
          <tr>
            <th class="service" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Nombre Medicina:</th>
            <th class="desc" style="padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;text-align:left;" >Dósis:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Cada:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Inicio de toma:</th>
            <th style="text-align:center;padding-top:5px;padding-bottom:5px;padding-right:20px;padding-left:20px;color:#5D6975;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#C1CED9;white-space:nowrap;font-weight:normal;" >Indicaciones extra:</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" >Design</td>
            <td class="desc" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:left;vertical-align:top;" >Creating a recognizable design solution based on the company's existing visual identity</td>
            <td class="unit" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" >000</td>
            <td class="qty" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" >000</td>
            <td class="total" style="padding-top:20px;padding-bottom:20px;padding-right:20px;padding-left:20px;text-align:right;font-size:1.2em;" >000</td>
          </tr>
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
        <div style="white-space:nowrap;" >Clinica San Antonio</div>
        <div style="white-space:nowrap;" >1945 Independencia,<br /> Los Mochis Sianaloa 45621, MX.</div>
        <div style="white-space:nowrap;" >(668) 812-1348</div>
        <div style="white-space:nowrap;" ><a href="mailto:brucamer@gmail.com" style="color:#5D6975;text-decoration:underline;" >brucamer@gmail.com</a></div>
      </div>

    <div id="footer"style="color:#5D6975;width:100%;height:30px;position:absolute;bottom:0;border-top-width:1px;border-top-style:solid;border-top-color:#C1CED9;padding-top:8px;padding-bottom:8px;padding-right:0;padding-left:0;text-align:center;" >
      SISAL 2017.
    </div>
  </body>
</html>