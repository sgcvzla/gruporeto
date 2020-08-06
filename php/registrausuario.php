<?php 
header('Content-Type: application/json');
include_once("../_config/conexion.php");

$query  = 'INSERT INTO usuarios (email, usuario, pregunta, hashp, hashr, status) ';
$query .= 'VALUES ("'.$_POST["email"].'", "'.$_POST["usuario"].'", "'.$_POST["question"].'",';
$query .= ' "'.$_POST["hashp"].'", "'.$_POST["hashr"].'", '.$_POST["status"].')';
if ($result = mysql_query($query, $link)) {
   $respuesta = '{"exito":"SI",';
   $respuesta .= '"mensaje":"Registro exitoso"}';
} else {
   $respuesta = '{"exito":"NO",';
   $respuesta .= '"mensaje":"Falló el registro."}';
}

echo $respuesta;
?>
