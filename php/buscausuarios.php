<?php 
header('Content-Type: application/json');
include_once("../_config/conexion.php");

$query = 'SELECT * FROM usuarios where email="'.$_GET["email"].'"';
$result = mysql_query($query, $link);
$id = 0;
if ($row = mysql_fetch_array($result)) {
    $id = $row['id'];
    if ($row["status"]) {
        $respuesta = '{"exito":"SI",';
        $respuesta .= '"id":'.$id.',';
        $respuesta .= '"usuario":"' . $row["usuario"] . '",';
        $respuesta .= '"pregunta":"' . $row["pregunta"] . '",';
        $respuesta .= '"hashp":"'. $row["hashp"] .'",';
        $respuesta .= '"hashr":"' . $row["hashr"] . '",';
        $respuesta .= '"status":'.$row["status"].',';
        $respuesta .= '"mensaje":"exito"}';
    } else {
        $respuesta = '{"exito":"SI",';
        $respuesta .= '"id":'.$id.',';
        $respuesta .= '"usuario":"' . $row["usuario"] . '",';
        $respuesta .= '"pregunta":"' . $row["pregunta"] . '",';
        $respuesta .= '"hashp":"'. $row["hashp"] .'",';
        $respuesta .= '"hashr":"' . $row["hashr"] . '",';
        $respuesta .= '"status":'.$row["status"].',';
        $respuesta .= '"mensaje":"usuario inactivo"}';
    }    
} else {
    $respuesta = '{"exito":"NO",';
    $respuesta .= '"id":'.$id.',';
    $respuesta .= '"usuario":"",';
    $respuesta .= '"pregunta":"",';
    $respuesta .= '"hashp":"",';
    $respuesta .= '"hashr":"",';
    $respuesta .= '"status":0,';
    $respuesta .= '"mensaje":"correo no registrado"}';
}
echo $respuesta;
?>
