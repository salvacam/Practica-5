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

if (!Validar::isAltaProducto($nombre, $descripcion, $precio, $iva)) {
    header('Location:index.php?mensaje=No se ha podido crear el producto. Datos no validos');
    exit();    
}

    echo "datos validos";

//coger nombre y extension de la imagen

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$producto = new Producto(null, $nombre, $descripcion, $precio, $iva);
$r = $modelo->add($producto);

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
                move_uploaded_file($tmp, "../fotos/" . $r . "/img" . $ext);
                $fotoPpal = "img" . $ext;
                $objeto = $modelo->get($r);
                $objeto->setImagen($fotoPpal);
                var_dump($objeto);
                $modelo->edit($objeto);
                header('Location:index.php?mensaje=Creado el producto');
                exit();
            } else {
                header('Location:index.php?mensaje=Creado el producto sin foto');
                exit();
            }
        } else {
            header('Location:index.php?mensaje=Creado el producto sin foto');            
            exit();
        }
    } else {
        header('Location:index.php?mensaje=Creado el producto sin foto');
        exit();
    }
} else {
    header('Location:index.php?mensaje=No se ha creado el producto');
    exit();
}


