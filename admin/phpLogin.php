<?php
require '../require/comun.php';
$nombre = Leer::post("nombre");
$clave = Leer::post("clave");
$bd = new BaseDatos();
$modelo = new ModeloUser($bd);
$user = $modelo->get($nombre, $clave);
$bd->closeConexion();
if($user->getNombre() == null ){
    //$sesion->cerrar();
    header("Location:../admin/viewLogin.php?error=Datos erroneos");
} else {
    $sesion->setUsuario($user);
    header("Location:../admin/index.php");
}