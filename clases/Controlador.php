<?php

class Controlador {

    function selectView() {
        $uri = $_SERVER['REQUEST_URI']; /*
          $posIni = strpos($uri, "mvc");
          $cadena = substr($uri, $posIni + 3); */
        $punto = ".";
        if (strpos($uri, "require/") || strpos($uri, "plantilla/") || strpos($uri, "clases/")) {
            $punto = "..";
        }
        $pagina = 0;
        if (Leer::get("pagina") != null) {
            $pagina = Leer::get("pagina");
        }
        $order = "nombre";
        if (Leer::get("order") != null) {
            $order = Leer::get("order");
        }

        $bd = new BaseDatos();
        $modelo = new ModeloProducto($bd);
        $total = $modelo->count("nombre NOT LIKE '#%'");
        $enlaces = Util::getEnlacesPaginacion($pagina, $total[0], 2, "?order=$order");
        $lista = $modelo->getList($pagina, 2, "nombre NOT LIKE '#%'", array(), $order);

        $productos = "";

        foreach ($lista as $llave => $valor) {
            $ruta = "fotos/" . $valor->getId() . "/" . $valor->getImagen();
            if ($valor->getImagen() == NULL || !file_exists($ruta)) {
                $ruta = "img/logo.png";
            }
            $datos = array(
                "nombre" => $valor->getNombre(),
                "precio" => $valor->getPrecio(),
                "iva" => $valor->getIva(),
                "ruta" => $ruta,
                "id" => $valor->getId(),
                "descripcion" => $valor->getDescripcion(),
                "pagina" => $pagina,
                "order" => $order,
                "punto" => $punto
            );
            $v = new Vista("plantillaProductos", $datos);
            $productos .= $v->renderDatos();
        }

        $datos = array(
            "inicio" => $enlaces["inicio"],
            "anterior" => $enlaces["anterior"],
            "primero" => $enlaces["primero"],
            "segundo" => $enlaces["segundo"],
            "actual" => $enlaces["actual"],
            "cuarto" => $enlaces["cuarto"],
            "quinto" => $enlaces["quinto"],
            "siguiente" => $enlaces["siguiente"],
            "ultimo" => $enlaces["ultimo"]
        );

        $v = new Vista("plantillaPaginacion", $datos);
        $paginacion = $v->renderDatos();

        $sesion = SesionSingleton::getSesion();
        $cesta = "";
        if ($sesion->get("__cesta") !== null) {
            $cesta = $_SESSION["__cesta"];
            if ($cesta->getTotal() > 0) {
                $lineas = "";
                $bol = TRUE;
                foreach ($cesta as $indice => $linea) {
                    if ($bol) {
                        $class = "pure-table-odd";
                        $bol = FALSE;
                    } else {
                        $class = "";
                        $bol = TRUE;
                    }

                    $datos = array(
                        "class" => $class,
                        "nombre" => $linea->getProducto()->getNombre(),
                        "precio" => $linea->getProducto()->getPrecio(),
                        "cantidad" => $linea->getCantidad(),
                        "id" => $linea->getProducto()->getId(),
                        "pagina" => $pagina,
                        "order" => $order,
                        "punto" => $punto
                    );
                    $v = new Vista("plantillaLinea", $datos);
                    $lineas .= $v->renderDatos();
                }

                $total = $cesta->getTotal();
                $datos = array(
                    "lineas" => $lineas,
                    "total" => $total,
                    "punto" => $punto
                );

                $v = new Vista("plantillaCarrito", $datos);
                $cesta = $v->renderDatos();
            } else {
                $cesta = "";
            }
        }

        $datos = array(
            "carrito" => $cesta,
            "productos" => $productos,
            "paginacion" => $paginacion,
            "punto" => $punto
        );
        $vista = new Vista("plantillaIndex", $datos);
        echo $vista->renderDatos();
    }

    function addDo() {
        $pagina = 0;
        if (Leer::request("pagina") != null) {
            $pagina = Leer::request("pagina");
        }
        $order = "nombre";
        if (Leer::request("order") != null) {
            $order = Leer::request("order");
        }
        $id = Leer::request("id");

        $sesion = SesionSingleton::getSesion();
        if ($sesion->getCesta() !== null) {
            $cesta = $sesion->getCesta();
        } else {
            $cesta = new Cesta();
            $sesion->setCesta($cesta);
        }

        $cesta->add($id);
        $sesion->setCesta($cesta);
        if (Leer::get("destino") == NULL) {
            header("Location:?pagina=$pagina&order=$order");
        } else {
            header("Location:?op=confirm&action=view");
        }
    }

    function subDo() {
        $pagina = 0;
        if (Leer::request("pagina") != null) {
            $pagina = Leer::request("pagina");
        }
        $order = "nombre";
        if (Leer::request("order") != null) {
            $order = Leer::request("order");
        }
        $id = Leer::request("id");

        $sesion = SesionSingleton::getSesion();
        if ($sesion->getCesta() !== null) {
            $cesta = $sesion->getCesta();
        } else {
            header("Location:?pagina=$pagina&order=$order");
            exit();
        }

        $cesta->sub($id);
        $sesion->setCesta($cesta);
        if (Leer::get("destino") !== null && $sesion->getCesta()->getTotal() > 0) {
            header("Location:?op=confirm&action=view");
        } else {
            header("Location:?pagina=$pagina&order=$order");
        }
    }

    function deleteDo() {
        $pagina = 0;
        if (Leer::request("pagina") != null) {
            $pagina = Leer::request("pagina");
        }
        $order = "nombre";
        if (Leer::request("order") != null) {
            $order = Leer::request("order");
        }
        $id = Leer::request("id");

        $sesion = SesionSingleton::getSesion();
        if ($sesion->getCesta() !== null) {
            $cesta = $sesion->getCesta();
        } else {
            header("Location:?pagina=$pagina&order=$order");
            exit();
        }

        $cesta->delete($id);
        $sesion->set("__cesta", $cesta);
        if (Leer::get("destino") == NULL || $sesion->getCesta) {
            header("Location:?pagina=$pagina&order=$order");
        } else {
            header("Location:?op=confirm&action=view");
        }

        if (Leer::get("destino") !== null && $sesion->getCesta()->getTotal() > 0) {
            header("Location:?op=confirm&action=view");
        } else {
            header("Location:?pagina=$pagina&order=$order");
        }
    }

    function deleteAllDo() {
        $pagina = 0;
        if (Leer::request("pagina") != null) {
            $pagina = Leer::request("pagina");
        }
        $order = "nombre";
        if (Leer::request("order") != null) {
            $order = Leer::request("order");
        }
        $id = Leer::request("id");

        $sesion = SesionSingleton::getSesion();
        if ($sesion->getCesta() !== null) {
            $cesta = $sesion->getCesta();
        } else {
            header("Location:?pagina=$pagina&order=$order");
            exit();
        }

        $cesta->cancelar();
        $sesion->set("__cesta", $cesta);
        header("Location:?pagina=$pagina&order=$order");
    }

    function confirmView() {
        $uri = $_SERVER['REQUEST_URI']; /*
          $posIni = strpos($uri, "mvc");
          $cadena = substr($uri, $posIni + 3); */
        $punto = ".";
        if (strpos($uri, "require/") || strpos($uri, "plantilla/") || strpos($uri, "clases/")) {
            $punto = "..";
        }

        $sesion = SesionSingleton::getSesion();
        $cesta = "";
        if ($sesion->get("__cesta") !== null) {
            $cesta = $_SESSION["__cesta"];
            if ($cesta->getTotal() > 0) {
                $lineas = "";
                $bol = TRUE;
                foreach ($cesta as $indice => $linea) {
                    if ($bol) {
                        $class = "pure-table-odd";
                        $bol = FALSE;
                    } else {
                        $class = "";
                        $bol = TRUE;
                    }

                    $datos = array(
                        "class" => $class,
                        "nombre" => $linea->getProducto()->getNombre(),
                        "precio" => $linea->getProducto()->getPrecio(),
                        "cantidad" => $linea->getCantidad(),
                        "id" => $linea->getProducto()->getId(),
                        "punto" => $punto
                    );
                    $v = new Vista("plantillaLineaConfirm", $datos);
                    $lineas .= $v->renderDatos();
                }

                $total = $cesta->getTotal();
                $datos = array(
                    "lineas" => $lineas,
                    "total" => $total,
                    "punto" => $punto
                );

                $v = new Vista("plantillaCarritoConfirm", $datos);
                $cesta = $v->renderDatos();
            } else {
                $cesta = "";
            }
        }

        $datos = array(
            "carrito" => $cesta,
            "punto" => $punto
        );
        $vista = new Vista("plantillaConfirm", $datos);
        echo $vista->renderDatos();
    }

    function confirmDo() {
        $uri = $_SERVER['REQUEST_URI']; /*
          $posIni = strpos($uri, "mvc");
          $cadena = substr($uri, $posIni + 3); */
        $punto = ".";
        if (strpos($uri, "require/") || strpos($uri, "plantilla/") || strpos($uri, "clases/")) {
            $punto = "..";
        }

        $nombre = Leer::get("nombre");
        $direccion = Leer::get("direccion");

        $sesion = SesionSingleton::getSesion();

        if ($nombre == "" || $direccion == "") {
            header("Location:?pagina=$pagina&order=$order");
            //header("Location:../index.php");
            exit();
        }
        //crear detalleVenta y venta
        $cestaSesion = $sesion->getCesta();
        if ($cestaSesion != null) {
            $venta = new Venta(null, null, $nombre, $direccion, "No");
            $bd = new BaseDatos();
            $modeloVenta = new ModeloVenta($bd);
            $r = $modeloVenta->add($venta); //es el idVenta
            $modeloDetalle = new ModeloDetalleVenta($bd);
            foreach ($cestaSesion as $indice => $linea) {
                $detalle = new DetalleVenta(null, $r, $linea->getProducto()->getId(), $linea->getCantidad(), $linea->getProducto()->getPrecio(), $linea->getProducto()->getIva());
                $modeloDetalle->add($detalle);
            }
        }

        $sesion->cerrar();
        $datos = array(
            "item_name" => "venta-".$r,
            "total" => $cestaSesion->getTotal(),
            "punto" => $punto
        );
        $vista = new Vista("plantillaPaypal", $datos);
        echo $vista->renderDatos();
    }

    function graciasView() {
        $uri = $_SERVER['REQUEST_URI'];
        $punto = ".";
        if (strpos($uri, "require/") || strpos($uri, "plantilla/") || strpos($uri, "clases/")) {
            $punto = "..";
        }
        $datos = array(
            "punto" => $punto
        );
        $vista = new Vista("plantillaGracias", $datos);
        echo $vista->renderDatos();
    }

    function paypalDo() {
        $texto = "";
        $salida = array();
        foreach ($_POST as $nombre => $valor) {
            $texto.="$nombre => $valor\n";
            $salida[$nombre] = $valor;
        }
        file_put_contents("log.txt", $texto, FILE_APPEND);
        file_put_contents("log.txt", "***********\n", FILE_APPEND);

        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($cURL, CURLOPT_URL, "https://www.sandbox.paypal.com/cgi-bin/webscr");
        curl_setopt($cURL, CURLOPT_ENCODING, 'gzip');
        curl_setopt($cURL, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($cURL, CURLOPT_POST, true);
        $_POST['cmd'] = '_notify-validate';
        curl_setopt($cURL, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($cURL, CURLOPT_HEADER, false);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($cURL, CURLOPT_FORBID_REUSE, true);
        curl_setopt($cURL, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($cURL, CURLOPT_TIMEOUT, 60);
        curl_setopt($cURL, CURLINFO_HEADER_OUT, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Connection: close',
            'Expect: ',
        ));
        $respuesta = curl_exec($cURL);
        $estatus = (int) curl_getinfo($cURL, CURLINFO_HTTP_CODE);
        file_put_contents("log.txt", "Estatus: " . $estatus . "\n", FILE_APPEND);
        file_put_contents("log.txt", "Pago: " . $respuesta . "\n", FILE_APPEND);
        file_put_contents("log.txt", "**********************\n", FILE_APPEND);

        curl_close($cURL);

        $idVenta = substr($salida["item_name"], 6);
        file_put_contents("log.txt", "idVenta: " . $idVenta . "\n", FILE_APPEND);
        file_put_contents("log.txt", "**********************\n", FILE_APPEND);

        $salida["idVenta"] = $idVenta;
        $salida["estatus"] = $estatus;
        $salida["pago"] = $respuesta;

        file_put_contents("log.txt", "Antes del contructor**********************\n", FILE_APPEND);
        $paypal = new Paypal();
        file_put_contents("log.txt", "contructor**********************\n", FILE_APPEND);
        $paypal->setNoId($salida);
        file_put_contents("log.txt", "setNoId**********************\n", FILE_APPEND);
        $bd = new BaseDatos();
        $modelo = new ModeloPaypal($bd);
        file_put_contents("log.txt", "************************************\n", FILE_APPEND);
        file_put_contents("log.txt", "paypal: " . $paypal->getJSON() . "\n", FILE_APPEND);
        file_put_contents("log.txt", "add: " . $modelo->add($paypal) . "\n", FILE_APPEND);
        //$r = $modelo->add($paypal);
        //file_put_contents("log.txt", "guardado: ". $r."\n", FILE_APPEND);
        file_put_contents("log.txt", "**********************\n", FILE_APPEND);

        $modVenta = new ModeloVenta($bd);
        file_put_contents("log.txt", "modVenta:$idVenta**********************\n", FILE_APPEND);
        $venta = $modVenta->get($idVenta);
        file_put_contents("log.txt", $venta . "\n", FILE_APPEND);
        file_put_contents("log.txt", "**********************\n", FILE_APPEND);
        if ($venta->getId() != NULL) {
            file_put_contents("log.txt", "entra con" . $salida['pago'] . "***********\n", FILE_APPEND);
            if ($salida["pago"] == "VERIFIED") {
                $venta->setPago("Si");
                file_put_contents("log.txt", "pago si\n", FILE_APPEND);
            } elseif ($salida["pago"] == "INVALID") {
                $venta->setPago("No");
                file_put_contents("log.txt", "pago no\n", FILE_APPEND);
            } else {
                $venta->setPago("Duda");
                file_put_contents("log.txt", "pago duda\n", FILE_APPEND);
            }
            $modVenta->edit($venta);
            file_put_contents("log.txt", "modifico la venta\n", FILE_APPEND);
        }
        file_put_contents("log.txt", "salgo\n", FILE_APPEND);
        $bd->closeConexion();
    }

    function handle() {
        $op = Leer::request("op");
        $action = Leer::request("action");
        //$target = Leer::request("target");
        $metodo = $op . ucfirst($action); // . ucfirst($target);
        if (method_exists($this, $metodo)) {
            $this->$metodo();
        } else {
            $this->selectView();
        }
    }

}
