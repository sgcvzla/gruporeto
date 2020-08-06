<?php
header('Content-Type: application/json');
include_once("../_config/conexion.php");

$valores = json_decode($_POST["seleccion"], true);

$mensaje = 'Hubo error al actualizar las transacciones: ';
$errores = 0;
$coma = '';
foreach ($valores["confirmar"] as $confirmar => $transaccion) {
  $query = 'SELECT * FROM reportepago WHERE id='.$transaccion;
  $result = mysql_query($query, $link);
  $monto = 0.00;
  $flagerror = false;
  if ($row = mysql_fetch_array($result)) {
    $monto = $row['monto'];
    $fechareporte = $row['fechareporte'];
    $email = $row['email'];
    $nombre = $row['nombredepositante'];
    $concepto = $row['concepto'];

    $query = 'UPDATE reportepago SET status="Confirmado" WHERE id='.$transaccion;
    $result = mysql_query($query, $link);
    confirmacionemail($email,$nombre,$fechareporte,$concepto);
    $flagerror = false;
  } else {
    $flagerror = true;
  }
  if ($flagerror) {
    $coma = ($errores==0) ? '' : ',';
    $errores++;
    $mensaje .= $coma.$transaccion;
  }
}
foreach ($valores["anular"] as $anular => $transaccion) {
  $query = 'UPDATE reportepago SET status="Anulado" WHERE id='.$transaccion;
  $flagerror = false;
  if($result = mysql_query($query, $link)) {
    $flagerror = false;
  } else {
    $flagerror = true;
  }
  if ($flagerror) {
    $coma = ($errores==0) ? '' : ',';
    $errores++;
    $mensaje .= $coma.$transaccion;
  }
}
if ($errores>0) {
  $respuesta = '{';
  $respuesta .= '"exito":"NO",';
  $respuesta .= '"mensaje":"' . utf8_encode($mensaje.' comuniquese con soporte técnico al +584244071820.') . '"';
  $respuesta .= '}';
} else {
  $respuesta = '{';
  $respuesta .= '"exito":"SI",';
  $respuesta .= '"mensaje":"' . utf8_encode('Proceso exitoso.') . '"';
  $respuesta .= '}';
}
echo $respuesta;


function confirmacionemail($correo,$nombre,$fechareporte,$concepto) {
$fecha1 = substr($fechareporte,8,2).'/'.substr($fechareporte,5,2).'/'.substr($fechareporte,0,4);
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
  <table width="400" height="auto" align=""center>
    <tbody>
      <tr>
        <td>
          <div style="padding: 10px; border: thin solid black; text-align: center;font-family: Arial; color: gray;">
            <p><img src="https://app.gruporeto.net/img/gruporeto.jpg" width="120" height="auto" /></p>
            <p>
              <span style="font-size: 150%; color: blue;">
                <b>¡Pago verificado!</b>
              </span>
            </p>
            <p>Estimado, <b>'.trim($nombre).'</b></p>

            <p>Su pago reportado el día '.$fecha1.' ha sido verirficado exitosamente.</p>
              
            <p>Servicio solicitado: <b>'.$concepto.'</b></p>
            
            <p>Su solicitud está siendo procesada y se le notificará la fecha de su cita a la brevedad posible.</p>

            <p><i>¡Gracias por confiar en nosotros!</i></p>

            <p style="font-size: 80%;"><b>Si tienes alguna pregunta o comentario, contáctanos a través de <a href="mailto:contigofo@gruporeto.net">este enlace</a></b></p>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>';

$asunto = utf8_decode('Pago verificado.');

$cabeceras = 'Content-type: text/html; charset=utf-8'."\r\n";
$cabeceras .= 'From: '.utf8_decode('Portal Grupo Reto <noreply@gruporeto.net>');

mail($correo,$asunto,$mensaje, $cabeceras);

$a = fopen('log.html','w+');
fwrite($a,$asunto);
fwrite($a,'-');
fwrite($a,$mensaje);
}
?>
