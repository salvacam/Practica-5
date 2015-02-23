<?php

require '../require/comun.php';
$sesion->autentificado("viewLogin.php");
$id = Leer::get("id");

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$producto = $modelo->get($id);
$num = 0;
$nombre = "#" . $num . "#" . $producto->getNombre() . "#";
$r = $modelo->borrar($id, $nombre);
while ($r < 1 && $num < 99) {
    $r = $modelo->borrar($id, "#" . $num++ . "#" . $producto->getNombre() . "#");
}

if ($r == 1) {
    $ruta = "../fotos/" . $id;    
    $directorio = opendir($ruta);
    while ($archivo = readdir($directorio)) { 
        if ($archivo != ".." && $archivo != ".") {
            unlink($ruta . DIRECTORY_SEPARATOR . $archivo);
        }
    }
    rmdir($ruta);
    $bd->closeConexion();
    header("Location:index.php?mensaje=Producto borrado");
    exit();
} else {
    $bd->closeConexion();
    header("Location:index.php?mensaje=No se pudo borrar");
}
