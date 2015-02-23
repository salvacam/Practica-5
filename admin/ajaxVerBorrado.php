<?php

require '../require/comun.php';
//header('Content-type: application/json');
header('Content-type: text/plain');

//comprobar que esta autentificado 
$sesion->autentificado("viewLogin.php");

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$ajax = $modelo->getListSinPaginar("nombre LIKE '#%'");
//var_dump($ajax);
$salida = "";
foreach ($ajax as $key => $value) {    
    $salida .= "Nombre: ". $value->getNombre()."<br/>"; 
}
if ($salida == "") {
    echo "NO";
} else {
    echo $salida;
}
