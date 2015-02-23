<?php

require '../require/comun.php';
header('Content-type: application/json');

//comprobar que esta autentificado 
$sesion->autentificado("viewLogin.php");

$id = Leer::get("id");

$bd= new BaseDatos();
$modelo = new ModeloVenta($bd);

echo $modelo->getListSinPaginarJSON("id=$id");

