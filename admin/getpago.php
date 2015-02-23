<?php
require '../require/comun.php';

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
file_put_contents("log.txt", "Estatus: ". $estatus ."\n", FILE_APPEND);
file_put_contents("log.txt", "Pago: ". $respuesta ."\n", FILE_APPEND);
file_put_contents("log.txt", "**********************\n", FILE_APPEND);

curl_close($cURL);

$idVenta = substr($salida["item_name"],6);
file_put_contents("log.txt", "idVenta: ". $idVenta."\n", FILE_APPEND);
file_put_contents("log.txt", "**********************\n", FILE_APPEND);

$salida["idVenta"] = $idVenta;
$salida["estatus"] = $estatus;
$salida["pago"] = $respuesta;

file_put_contents("log.txt", "Antes del contructor**********************\n", FILE_APPEND);
$paypal = new Paypal();
file_put_contents("log.txt", "contructor**********************\n", FILE_APPEND);
$paypal->setNoId($salida);
file_put_contents("log.txt", "setNoId**********************\n", FILE_APPEND);
$bd= new BaseDatos();
$modelo = new ModeloPaypal($bd);
file_put_contents("log.txt", "************************************\n", FILE_APPEND);
file_put_contents("log.txt", "paypal: ". $paypal->getJSON()."\n", FILE_APPEND);
file_put_contents("log.txt", "add: ". $modelo->add($paypal)."\n", FILE_APPEND);
//$r = $modelo->add($paypal);
//file_put_contents("log.txt", "guardado: ". $r."\n", FILE_APPEND);
file_put_contents("log.txt", "**********************\n", FILE_APPEND);

$modVenta = new ModeloVenta($bd);
file_put_contents("log.txt", "modVenta:$idVenta**********************\n", FILE_APPEND);
$venta = $modVenta->get($idVenta);
file_put_contents("log.txt", $venta."\n", FILE_APPEND);
file_put_contents("log.txt", "**********************\n", FILE_APPEND);
if($venta->getId() != NULL){
    file_put_contents("log.txt", "entra con". $salida['pago']."***********\n", FILE_APPEND);
    if($salida["pago"] == "VERIFIED"){
        $venta->setPago("Si");
        file_put_contents("log.txt", "pago si\n", FILE_APPEND);
    } elseif($salida["pago"] == "INVALID"){
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
