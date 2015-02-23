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
    $url = Entorno::getEnlaceCarpeta() . Entorno::getPagina() . "?" . Entorno::getParametros();
}

//sacar un listado de los productos
$bd = new BaseDatos();
$modelo = new ModeloPaypal($bd);
$total = $modelo->count();
$enlaces = Util::getEnlacesPaginacion($pagina, $total[0], 3, $url);
$lista = $modelo->getList($pagina, 3, "1=1", array(), $order);
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
                            <a href="index.php" class="pure-button">Productos</a>
                            <a href="ventas.php" class="pure-button">Ventas</a>
                            <a href="#"class="pure-button pure-button-active">Registro Paypal</a>
                        </div>
                    </div>
                    <div class="email-content-body pure-u-1 back">       
                        <table class="pure-table">
                            <thead>
                                <tr>
                                    <!--//plantilla titulo tabla -->
                                    <th>Id</th>
                                    <th>IdVenta</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Correo</th>
                                    <th>Estatus</th>
                                    <th>Pago</th>
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
                                        <td><?php echo $linea->getIdVenta(); ?></td>
                                        <td><?php echo $linea->getMc_gross(); ?></td>
                                        <td><?php echo $linea->getPayment_date(); ?></td>
                                        <td><?php echo $linea->getPayer_email(); ?></td>
                                        <td><?php echo $linea->getEstatus(); ?></td>
                                        <td><?php echo $linea->getPago(); ?></td>
                                        <td><a data-id = "<?php echo $linea->getIdVenta(); ?>" href="#" class="secondary-button pure-button venta">
                                                Venta
                                            </a> 
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
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
                            <a class="secondary-button pure-button ordenar" href="?order=idVenta">Por IdVenta</a>
                            <a class="secondary-button pure-button ordenar" href="?order=idVenta Desc">Por IdVenta Inverso</a>
                            <br/>                            
                            <br/>                            
                            <a class="secondary-button pure-button ordenar" href="?order=mc_gross">Por Cantidad</a>
                            <a class="secondary-button pure-button ordenar" href="?order=mc_gross Desc">Por Cantidad Inverso</a>
                            <a class="secondary-button pure-button ordenar" href="?order=payment_date">Por Fecha</a>
                            <a class="secondary-button pure-button ordenar" href="?order=payment_date Desc">Por Fecha Inverso</a>                        
                            <br/>
                            <br/>
                            <a class="secondary-button pure-button ordenar" href="?order=payer_email">Por Nombre</a>
                            <a class="secondary-button pure-button ordenar" href="?order=payer_email Desc">Por Nombre Inverso</a>                        
                            <a class="secondary-button pure-button ordenar" href="?order=pago">Por Pago</a>
                            <a class="secondary-button pure-button ordenar" href="?order=pago Desc">Por Pago Inverso</a>                     
                        </div>

                    </div>                    
                </div>
            </div>
        </div>
    </body>
    <script>
        var venta = document.getElementsByClassName("venta");
        for (var i = 0; i < venta.length; i++) {
            venta[i].addEventListener("click", function () {
                var id = this.getAttribute("data-id");
                var ajax = new XMLHttpRequest();
                ajax.open("GET", "ajaxVerVenta.php?id=" + id, true);
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        var ojson = JSON.parse(ajax.responseText);
                        console.log(ojson);
                        var salida = "";
                        for (var j = 0; j < ojson.length; j++) {
                            salida += "Fecha-Hora: " + ojson[j].fechaHora + "<br/>Clienta: " + ojson[j].nombre + "<br/>";
                            salida += "Direccion: " + ojson[j].direccion + "<br/>Pago: " + ojson[j].pago + "<br/><br/>";
                        }
                        alertify.alert(salida);
                    }
                };
                ajax.send();
            });
        }
    </script>

</html>
