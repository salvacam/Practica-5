<?php

require '../require/comun.php';
//header('Content-type: application/json');
header('Content-type: text/plain');

//comprobar que esta autentificado 
$sesion->autentificado("viewLogin.php");

$id = Leer::get("id");

$bd= new BaseDatos();
$modelo = new ModeloPaypal($bd);
$ajax = $modelo->getVenta($id);
if($ajax == ""){    
    echo "No se ha pagado.";
} else {
    echo $ajax;
}
