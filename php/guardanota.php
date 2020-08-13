<?php
header('Content-Type: application/json');
include_once("../_config/conexion.php");

$respuesta = '{';
$respuesta .= '"exito":"NO",';
$respuesta .= '"mensaje":"' . utf8_encode('Nota no enviada') . '"';
$respuesta .= '}';

$exito = 'SI';

$query  = 'update reportepago set nota="'.$_POST["nota"].'", fechacita="'.$_POST["fechacita"].'", horacita="'.$_POST["horacita"].'" where id='.$_POST["id"];
// echo $query;
if($result = mysql_query($query, $link)) {
  $si = 'SI';
  $mensaje = 'Registro exitoso';
} else {
  $si = 'NO';
  $mensaje = 'Ocurrió un error';
}
$respuesta = '{';
$respuesta .= '"exito":"'.$si.'",';
$respuesta .= '"mensaje":"' . $mensaje . '"';
$respuesta .= '}';

echo $respuesta;
?>
