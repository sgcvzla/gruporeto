<?php
header('Content-Type: application/json');
// include_once("./lib/popclikemail.php");
include_once("../_config/conexion.php");

$respuesta = '{';
$respuesta .= '"exito":"NO",';
$respuesta .= '"mensaje":"' . 'Feedback no registrado' . '"';
$respuesta .= '}';

$exito = 'SI';
$fechareporte = date('Y-m-d');

$email  = $_POST["email"];
$nombre = $_POST["nombre"];

$feedback = $_POST["feedback"];

$fecha1 = $_POST["fecha1"];
$hora1  = $_POST["hora1"];

$fecha2 = $_POST["fecha2"];
$hora2  = $_POST["hora2"];

$fecha3 = $_POST["fecha3"];
$hora3  = $_POST["hora3"];

$status = 'Pendiente por confirmar';

$query  = 'INSERT INTO feedback (email, nombre, fechareporte, feedback, fecha1, hora1, fecha2, hora2, fecha3, hora3, status) ';
$query .= 'VALUES ("'.$email.'","'.$nombre.'","'.$fechareporte.'","'.$feedback.'","'.$fecha1.'","'.$hora1.'","'.$fecha2.'","'.$hora2.'",';
$query .= '"'.$fecha3.'","'.$hora3.'","'.$status.'")';
if($result = mysql_query($query, $link)) {
  $si = 'SI';
  $mensaje = 'Feedback registrado exitosamente';
  enviaremail($email,$nombre,$fechareporte,$feedback,$fecha1,$hora1,$fecha2,$hora2,$fecha3,$hora3);
} else {
  $si = 'NO';
  $mensaje = 'Ocurrió un error en el registro de la transacción';
}
$respuesta = '{';
$respuesta .= '"exito":"'.$si.'",';
$respuesta .= '"mensaje":"' . $mensaje . '"';
$respuesta .= '}';

echo $respuesta;


function enviaremail($correo,$nombre,$fechareporte,$feedback,$fecha1,$hora1,$fecha2,$hora2,$fecha3,$hora3) {
$fechareporte = substr($fechareporte,8,2).'/'.substr($fechareporte,5,2).'/'.substr($fechareporte,0,4);
$fecha1 = substr($fecha1,8,2).'/'.substr($fecha1,5,2).'/'.substr($fecha1,0,4);
$fecha2 = substr($fecha2,8,2).'/'.substr($fecha2,5,2).'/'.substr($fecha2,0,4);
$fecha3 = substr($fecha3,8,2).'/'.substr($fecha3,5,2).'/'.substr($fecha3,0,4);
$mensaje = 
  '<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recibo</title>
    <link rel="stylesheet" href="">
  </head>
  <body>
    <table height="auto" align="center" style="">
      <tbody>
        <tr>
          <td>
            <div style="padding: 10px; text-align: justify; font-family: Arial;">
              <p><img src="https://app.gruporeto.net/img/gruporeto.jpg" width="120" height="auto" /></p>
              <p>Estimado, <b>'.trim($nombre).'</b></p>
            
              <p>Hemos analizado brevemente la información que suministró y le presentamos los siguientes comentarios:</p>

              <p><b>'.$feedback.'</b></p>

              <p>Si deseas profundizar en alguno de estos temas puedes solicitar una cita para una sesión personalizada, las fechas y hora disponibles son:</p>
              
              <ul>
                 <li>Opción 1: <a href="https://app.gruporeto.net/reportepago/index.html?fecha='.$fecha1.'&hora='.$hora1.'"><b>'.$fecha1.'</b> a las <b>'.$hora1.' horas</b></a></li>
                 <br/>
                 <li>Opción 2: <a href="https://app.gruporeto.net/reportepago/index.html?fecha='.$fecha2.'&hora='.$hora2.'"><b>'.$fecha2.'</b> a las <b>'.$hora2.' horas</b></a></li>
                 <br/>
                 <li>Opción 3: <a href="https://app.gruporeto.net/reportepago/index.html?fecha='.$fecha3.'&hora='.$hora3.'"><b>'.$fecha3.'</b> a las <b>'.$hora3.' horas</b></a></li>
              </ul>

              <p><i>¡Gracias por confiar en nosotros!</i></p>

              <p style="font-size: 80%;"><b>Si tienes alguna pregunta o comentario, contáctanos a través de <a href="mailto:contigofo@gruporeto.net">este enlace</a></b></p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
  </html>';

$asunto = utf8_decode('Feedback Grupo Reto.');

$cabeceras = 'Content-type: text/html; charset=utf-8'."\r\n";
$cabeceras .= 'From: '.utf8_decode('Portal Grupo Reto <noreply@gruporeto.net>');

$a = fopen('log.html','w+');
fwrite($a,$asunto);
fwrite($a,'-');
fwrite($a,$mensaje);

mail($correo,$asunto,$mensaje,$cabeceras);
//   popclikemail($correo,$nombres,$asunto,$mensaje);
}
?>
