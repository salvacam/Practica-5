<?php
require '../require/comun.php';

//comprobar que esta autentificado 
$sesion->autentificado("viewLogin.php");

$order = "id";
if (Leer::get("order") != null) {
    $order = Leer::get("order");
}

$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}

$url = "";
if (Entorno::getParametros() !== null) {
    $parametros = Entorno::getParametros();
    if (substr($parametros, 0, 1) == "&") {
        $parametros = substr($parametros, 1);
    }
    $param = preg_replace('/(pagina=.*)/', '', $parametros);
    $param = preg_replace('/(mensaje=.*)/', '', $param);
    if ($param != "") {
        $url = Entorno::getEnlaceCarpeta() . Entorno::getPagina() . "?" . $param;
    } else {
        $url = Entorno::getEnlaceCarpeta() . Entorno::getPagina();
    }
}

//sacar un listado de los productos
$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$total = $modelo->count("nombre NOT LIKE '#%'");
$enlaces = Util::getEnlacesPaginacion($pagina, $total[0], 3, $url);
$lista = $modelo->getList($pagina, 3, "nombre NOT LIKE '#%'", array(), $order);
?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A layout example that shows off a responsive email layout.">
        <title>Tienda Deportes</title>    
        <script src="../js/vendor/alertify.js"></script>
        <link rel="stylesheet" href="../css/vendor/pure-min.css">
        <link rel="stylesheet" href="../css/vendor/email.css">
        <link rel="stylesheet" href="../css/vendor/alertify.css">

    </head>

    <body>

        <div id="layout" class="content pure-g">
            <div id="nav" class="pure-u back">                
                <img src="../img/logo.png" id="logo" alt="logo" /> 
            </div>


            <div id="main" class="pure-u-1 back">
                <div class="email-content">
                    <div class="email-content-header pure-g">
                        <div class="pure-u-1 back">                        
                            <a href="phpLogout.php" class="secondary-button pure-button" id="desconectar">Desconectar</a>
                        </div>

                        <br/>
                        <br/>
                        <div class="pure-u-1 back">           
                            <!--//usar plantilla con los botones-->
                            <a href="#" class="pure-button pure-button-active">Productos</a>
                            <a href="ventas.php" class="pure-button">Ventas</a>
                            <a href="paypal.php" class="pure-button">Registro Paypal</a>
                        </div>
                    </div>
                    <div class="email-content-body pure-u-1 back">       
                        <table class="pure-table">
                            <thead>
                                <tr>
                                    <!--//plantilla titulo tabla -->
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Precio</th>
                                    <th>Iva</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bol = TRUE;
                                foreach ($lista as $indice => $linea) {
                                    if ($bol) {
                                        ?>
                                        <tr class="pure-table-odd">
                                            <?php
                                            $bol = FALSE;
                                        } else {
                                            ?>
                                        <tr>
                                            <?php
                                            $bol = TRUE;
                                        }
                                        ?>
                                        <!-- plantilla contenido y botones -->
                                        <td><?php echo $linea->getId(); ?></td>
                                        <td><?php echo $linea->getNombre(); ?></td>
                                        <td><?php echo $linea->getDescripcion(); ?></td>
                                        <td><?php echo $linea->getPrecio(); ?></td>
                                        <td><?php echo $linea->getIva(); ?></td>
                                        <td><a data-nombre ="<?php echo $linea->getNombre(); ?>"
                                               href="phpDelete.php?id=<?php echo $linea->getId(); ?>" 
                                               class="secondary-button pure-button borra">
                                                Borrar                                                    
                                            </a> 
                                        </td>
                                        <td>
                                            <a href="viewUpdate.php?id=<?php echo $linea->getId(); ?>" class="secondary-button pure-button edita">
                                                Editar
                                            </a> 
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="8">
                                        <a id="anadir" href="viewInsert.php" class="secondary-button pure-button">
                                            Añadir Producto
                                        </a> 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8">
                                        <button id="verBorrado" class="secondary-button pure-button">
                                            Producto Borrados
                                        </button> 
                                    </td>
                                </tr>
                            <thead>    
                            <td colspan="8">
                                <br/>
                                <ul id="cajaPaginacion" class="pure-paginator"> 
                                    <li><?php echo $enlaces["inicio"]; ?></li>
                                    <li><?php echo $enlaces["anterior"]; ?></li>
                                    <li><?php echo $enlaces["primero"]; ?></li>
                                    <li><?php echo $enlaces["segundo"]; ?></li>
                                    <li><?php echo $enlaces["actual"]; ?></li>
                                    <li><?php echo $enlaces["cuarto"]; ?></li>
                                    <li><?php echo $enlaces["quinto"]; ?></li>
                                    <li><?php echo $enlaces["siguiente"]; ?></li>
                                    <li><?php echo $enlaces["ultimo"]; ?></li>                    
                                </ul>
                            </td>
                            </thead>
                            </tbody>
                        </table>
                        <br/>   
                        <div class="pure-u">
                            Ordenar<br/>
                            <a class="secondary-button pure-button ordenar" href="?order=id">Por Id</a>
                            <a class="secondary-button pure-button ordenar" href="?order=id Desc">Por Id Inverso</a>
                            <a class="secondary-button pure-button ordenar" href="?order=nombre">Por Nombre</a>
                            <a class="secondary-button pure-button ordenar" href="?order=nombre Desc">Por Nombre Inverso</a>                        
                            <br/>
                            <br/>
                            <a class="secondary-button pure-button ordenar" href="?order=descripcion">Por Descripcion</a>
                            <a class="secondary-button pure-button ordenar" href="?order=descripcion Desc">Por Descripcion Inverso</a>                        
                            <a class="secondary-button pure-button ordenar" href="?order=precio">Por Precio</a>
                            <a class="secondary-button pure-button ordenar" href="?order=precio Desc">Por Precio Inverso</a>                     
                            <br/>
                            <br/>
                            <a class="secondary-button pure-button ordenar" href="?order=iva ">Por Iva</a>
                            <a class="secondary-button pure-button ordenar" href="?order=iva Desc">Por Iva Inverso</a>                     
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </body>
    <?php
    if (Leer::get("mensaje") != null) {
        $mensaje = Leer::get("mensaje");
        $pos = strpos($mensaje, "No");
        if ($pos !== FALSE) {
            echo "<script>alertify.error('$mensaje');</script>";
        } else {
            echo "<script>alertify.log('$mensaje');</script>";
        }
    }
    ?>
    <script>
        var borrar = document.getElementsByClassName("borra");
        for (var i = 0; i < borrar.length; i++) {
            borrar[i].addEventListener("click", function(evento) {
                var href = this.getAttribute("href");
                var nombre = this.getAttribute("data-nombre");
                evento.preventDefault();
                alertify.confirm("¿Quieres borrar el producto " + nombre + "?", function(e) {
                    if (e) {
                        window.location = href;
                    } else {
                        alertify.error('Cancelado el borrado');
                    }
                });
            });
        }
        var verBorrado = document.getElementById("verBorrado");
        verBorrado.addEventListener("click", function() {
            var ajax = new XMLHttpRequest();
            ajax.open("GET", "ajaxVerBorrado.php", true);
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                        console.log(ajax.responseText);
                        alertify.alert(ajax.responseText);
                    }
            };
            ajax.send();
        });
    </script>
</html>
