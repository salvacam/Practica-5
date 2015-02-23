<?php

class Producto {

    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $iva;
    private $imagen;

    function __construct($id = null,$nombre = null, $descripcion = null, $precio = null, $iva = null, $imagen = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->iva = $iva;
        $this->imagen = $imagen;
    }

    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->nombre = $datos[1 + $inicio];
        $this->descripcion = $datos[2 + $inicio];
        $this->precio = $datos[3 + $inicio];
        $this->iva = $datos[4 + $inicio];
        $this->imagen = $datos[5 + $inicio];
    }

    public function __toString() {
        return "Producto: {$this->getId()}  {$this->getNombre()} {$this->getDescripcion()} {$this->getPrecio()} {$this->getIva()} {$this->getImagen()}";
    }
    
    function getId() {
        return $this->id;
    }
    
    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getIva() {
        return $this->iva;
    }
    
    public function getImagen() {
        return $this->imagen;
    }
      
    function setId($id) {
        $this->id = $id;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }
    
    public function setImagen($imagen) {
        $this->imagen = $imagen;
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
