<?php

class Venta {

    private $id;
    private $fechaHora;
    private $nombre;
    private $direccion;
    private $pago;

    function __construct($id = null, $fechaHora = null, $nombre = null, $direccion = null, $pago = null) {
        $this->id = $id;
        $this->fechaHora = $fechaHora;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->pago = $pago;
    }

    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->fechaHora = $datos[1 + $inicio];
        $this->nombre = $datos[2 + $inicio];
        $this->direccion = $datos[3 + $inicio];
        $this->pago = $datos[4 + $inicio];
    }

    public function __toString() {
        return "Venta: {$this->getId()}  {$this->getFechaHora()} {$this->getNombre()} {$this->getDireccion()} {$this->getPago()}";
    }

    function getId() {
        return $this->id;
    }

    function getFechaHora() {
        return $this->fechaHora;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getPago() {
        return $this->pago;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFechaHora($fechaHora) {
        $this->fechaHora = $fechaHora;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setPago($pago) {
        $this->pago = $pago;
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
