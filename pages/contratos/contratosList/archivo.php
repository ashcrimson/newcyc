<?php 
ob_start();
$valores=array();
$valores[]=$_REQUEST["nro_documento"];

$sql="select archivo, nombre, tipo_archivo from documento where nro_documento=?";


// header('Content-Type: '.$res["tipo_archivo"]);
// header('Content-Disposition: attachment; filename='.$res["nombre"]);
// print($res["archivo"]);
?>