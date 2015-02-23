<?php

class JoinDetalleVentaProducto {

    private $detalleVenta, $producto;
    
    function __construct($detalleVenta, $producto) {
        $this->detalleVenta = $detalleVenta;
        $this->producto = $producto;
    }
    
    public function __toString() {
        return "{$this->detalleVenta} {$this->producto}";
    }
    
    function getDetalleVenta() {
        return $this->detalleVenta;
    }

    function getProducto() {
        return $this->producto;
    }
    
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = "{ ";
        foreach ($prop as $key => $value) {
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }

}
