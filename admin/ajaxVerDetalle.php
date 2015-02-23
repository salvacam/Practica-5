<?php
require '../require/comun.php';
header('Content-type: application/json');

//comprobar que esta autentificado 
$sesion->autentificado("viewLogin.php");

$id = Leer::get("id");

$bd = new BaseDatos();
$modelo = new ModeloDetalleVenta($bd);
//$modelo = new ModeloJoinDetalleVentaProducto($bd);
//$r = $modelo->getListPaginaSinPaginar("i.idVenta=$id");
$r = $modelo->getListSinPaginarProdJSON("idVenta=$id");
echo $r;
/*$salida = '[';
foreach ($r as $key => $value) {
    $salida .= $value->getJSON() . ',';
}

$salida = substr($salida, 0, -1);
$salida .= ']';

echo $salida;*/