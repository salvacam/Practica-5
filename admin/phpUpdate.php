<?php

require '../require/comun.php';
$sesion->autentificado("viewLogin.php");
$nombre = Leer::post("nombre");
var_dump($nombre);
$descripcion = Leer::post("descripcion");
var_dump($descripcion);
$precio = Leer::post("precio");
var_dump($precio);
$iva = Leer::post("iva");
var_dump($iva);

$id = Leer::post("id");
var_dump($id);

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$producto = $modelo->get($id);

$borrarImg = Leer::post("borrarImg");
var_dump($borrarImg);
if ($borrarImg == "on") {
    $producto->setImagen("");
    $ruta = "../fotos/" . $id;
    $directorio = opendir($ruta);
    while ($archivo = readdir($directorio)) {
        if ($archivo != ".." && $archivo != ".") {
            unlink($ruta . DIRECTORY_SEPARATOR . $archivo);
        }
    }
}

if (!Validar::isAltaProducto($nombre, $descripcion, $precio, $iva)) {
    header('Location:index.php?mensaje=No se ha editar crear el producto. Datos no validos');
    exit();
}

$producto->setNombre($nombre);
$producto->setDescripcion($descripcion);
$producto->setPrecio($precio);
$producto->setIva($iva);

$r = $modelo->edit($producto);

if ($r != -1) {
    $ruta = "../fotos/" . $r;
    if (!file_exists($ruta)) {
        mkdir($ruta, Configuracion::PERMISOS);
    }

    if (isset($_FILES["foto"])) {
        var_dump($ruta);
        $errores = 0;
        //ver el tipo mime, el tamaño, y que reemplaze
        if ($_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
            $tipo = explode("/", $_FILES["foto"]["type"]);
            $tamano = $_FILES["foto"]["size"];
            if ($tipo[0] == "image" && $tamano < 2097152) {   //0.5 megas "2097152"
                $tmp = $_FILES["foto"]["tmp_name"];
                $name = $_FILES["foto"]["name"];
                $pos = strrpos($name, ".");
                $ext = substr($name, $pos, 4);
                move_uploaded_file($tmp, "../fotos/" . $id . "/img" . $ext);
                $fotoPpal = "img" . $ext;
                $producto->setImagen($fotoPpal);
                $modelo->edit($producto);
                header('Location:index.php?mensaje=Editado el producto');
                exit();
            } else {
                header('Location:index.php?mensaje=Editado el producto sin foto');
                exit();
            }
        } else {
            header('Location:index.php?mensaje=Editado el producto sin foto');
            exit();
        }
    } else {
        header('Location:index.php?mensaje=Editado el producto sin cambiar foto');
        exit();
    }
} else {
    header('Location:index.php?mensaje=No se ha editado el producto');
    exit();
}


