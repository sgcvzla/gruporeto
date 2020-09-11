<?php
header('Content-Type: application/json');
// include_once("./lib/popclikemail.php");
include_once("../_config/conexion.php");

$respuesta = '{';
$respuesta .= '"exito":"NO",';
$respuesta .= '"mensaje":"' . 'Pago no enviado' . '"';
$respuesta .= '}';

$exito = 'SI';
$fechareporte = date('Y-m-d');
$origen            = $_POST["origen"];
$fechatransaccion  = $_POST["fecha"];
$nombredepositante = $_POST["cliente"];
$monto             = $_POST["monto"];
$referencia        = $_POST["referencia"];
$status            = 'Pendiente por verificar';
$correo            = $_POST["email"];
$concepto          = $_POST["concepto"];
$selFecha          = $_POST["selFecha"];
$fechaCita         = $_POST["fechaCita"];
$horaCita          = $_POST["horaCita"];

$query  = 'INSERT INTO reportepago(fechareporte, origen, fechatransaccion, nombredepositante, ';
$query .= 'monto, referencia, status, email, concepto, fechacita, horacita) VALUES ("'.$fechareporte.'","'.$origen.'","';
$query .= $fechatransaccion.'","'.$nombredepositante.'",'.$monto.',"'.$referencia.'","'.$status;
$query .= '","'.$correo.'","'.$concepto.'","'.$fechaCita.'","'.$horaCita.'")';
if($result = mysql_query($query, $link)) {
  $si = 'SI';
  $mensaje = 'Pago registrado exitosamente';
  enviaremail($correo,$fechareporte,$fechatransaccion,$nombredepositante,$monto,$referencia,$origen,$concepto,$fechaCita,$horaCita);
} else {
  $si = 'NO';
  $mensaje = 'Ocurrió un error en el registro de la transacción';
}
$respuesta = '{';
$respuesta .= '"exito":"'.$si.'",';
$respuesta .= '"mensaje":"' . $mensaje . '"';
$respuesta .= '}';

echo $respuesta;


function enviaremail($correo,$fechareporte,$fechapago,$nombres,$monto,$referencia,$origen,$concepto,$fechaCita,$horaCita) {
$fecha1 = substr($fechareporte,8,2).'/'.substr($fechareporte,5,2).'/'.substr($fechareporte,0,4);
$fecha2 = substr($fechapago,8,2).'/'.substr($fechapago,5,2).'/'.substr($fechapago,0,4);
$fecha3 = substr($fechaCita,8,2).'/'.substr($fechaCita,5,2).'/'.substr($fechaCita,0,4);
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
    <table width="400" height="auto" align="center">
      <tbody>
        <tr>
          <td>
            <div style="padding: 10px; border: thin solid black; text-align: center;font-family: Arial; color: gray;">
              <p><img src="https://app.gruporeto.net/img/gruporeto.jpg" width="120" height="auto" /></p>
              <p>
                <span style="font-size: 150%; color: blue;">
                  <b>¡Pago recibido!</b>
                </span>
              </p>
              <p>Estimado, <b>'.trim($nombres).'</b></p>

              <p>El día '.$fecha1.' hemos recibido el siguiente reporte de pago:</p>

              <p>Método de pago: <b>'.$origen.'</b></p>
              <p>Numero de referencia: <b>'.$referencia.'</b></p>
              <p>Monto: <b>USD '.number_format($monto,2,',','.').'</b></p>
              <p>Fecha de la transacción: <b>'.$fecha2.'</b></p>
              <p>Concepto del pago: <b>'.$concepto.'</b></p>
              <p>Fecha seleccionada para la cita: <b>'.$fecha3.'</b></p>

              <p><b>Una vez verificado el pago, recibirá un correo electrónico de confirmación.</b></p>

              <p><i>¡Gracias por confiar en nosotros!</i></p>

              <p style="font-size: 80%;"><b>Si tienes alguna pregunta o comentario, contáctanos a través de <a href="mailto:contigofo@gruporeto.net">este enlace</a></b></p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
  </html>';

$asunto = utf8_decode('Pago recibido.');

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
