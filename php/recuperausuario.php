<?php 
header('Content-Type: application/json');
include_once("../_config/conexion.php");

$query  = 'UPDATE usuarios SET hashp="'.$_POST["hashp"].'" ';
$query .= 'WHERE email="'.$_POST["email"].'"';
if($result = mysql_query($query, $link)) {
	$respuesta = '{"exito":"SI",';
	$respuesta .= '"mensaje":"Registro exitoso"}';
} else {
	$respuesta = '{"exito":"NO",';
	$respuesta .= '"mensaje":"Falló el registro."}';
}

echo $respuesta;
?>
