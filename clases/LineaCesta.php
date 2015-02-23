<?php

class LineaCesta {
    private $producto;    
    private $cantidad;
    
    function __construct(Producto $producto = null, $cantidad= null) {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
    }
    
    public function getProducto() {
        return $this->producto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setProducto($producto) {
        $this->producto = $producto;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
}
