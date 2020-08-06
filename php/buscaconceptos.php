<?php 
header('Content-Type: application/json');
include_once("../_config/conexion.php");

$query = 'SELECT * FROM productos order by concepto';
$result = mysql_query($query, $link);
$respuesta = '[';
$first = true;
while ($row = mysql_fetch_array($result)) {
   if ($row["status"]) {
      if ($first) {
         $first = false;
         $coma = '';
      } else {
         $coma = ',';
      }
      $respuesta .= $coma.'{';
      $respuesta .= '"id":'.$row["id"].',';
      $respuesta .= '"concepto":"' . $row["concepto"].'"';
      $respuesta .= '}';
      }
}
$respuesta .= ']';
echo $respuesta;
?>
