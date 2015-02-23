<?php

class Cesta implements Iterator {

    private $arrayCesta;
    private $contador = 0;

    function __construct() {
        $this->arrayCesta = array();
    }

    function add($id) {
        if (isset($this->arrayCesta[$id])) {
            $linea = $this->arrayCesta[$id];
            $linea->setCantidad($linea->getCantidad() + 1);
            return 1;
        } else {
            $bd = new BaseDatos();
            $modelo = new ModeloProducto($bd);
            $producto = $modelo->get($id);
            $linea = new LineaCesta($producto, 1);
            $this->arrayCesta[$id] = $linea;
            $bd->closeConexion();
            return 0;
        }
        return -1;
    }

    function sub($id) {
        if (isset($this->arrayCesta[$id])) {
            $linea = $this->arrayCesta[$id];
            $linea->setCantidad($linea->getCantidad() - 1);
            if ($linea->getCantidad() < 1) {
                $this->delete($id);
                return 1;
            }
            return 0;
        }
        return -1;
    }

    function delete($id) {
        unset($this->arrayCesta[$id]);
    }
    
    function cancelar(){        
        $this->arrayCesta = array();
    }

    function getTotal() {
        $total = 0;
        foreach ($this->arrayCesta as $indice => $valor) {
            $aux = ($valor->getCantidad() * $valor->getProducto()->getPrecio()) * ($valor->getProducto()->getIva() / 100);
            $total += ($valor->getCantidad() * $valor->getProducto()->getPrecio()) + $aux;
        }
        return round($total, 2);
    }

    /* public function getCesta() {
      return $this->arrayCesta;
      } */

    public function setCesta($cesta) {
        $this->arrayCesta = $cesta;
    }

    /*
     * Devuelve el valor que corresponde al contador
     * el contador es 0, 1, 2, 3 ....
     * las claves pueden ser cualquiera 11, 23, 37, 48
     * 
     */
    public function current() {
        $claves = array_keys($this->arrayCesta);
        //return $this->arrayCesta[$claves[$this->contador]];        
        return $this->arrayCesta[$this->key()];
    }

    //Devuelve la clave de la posicion
    public function key() {
        $claves = array_keys($this->arrayCesta);
        return $claves[$this->contador];
    }

    public function next() {
        $this->contador++;
    }

    public function rewind() {
        $this->contador = 0;
    }

    public function valid() {
        $claves = array_keys($this->arrayCesta);
        if (isset($claves[$this->contador])) {
            return isset($this->arrayCesta[$claves[$this->contador]]);
        }
        return false;
    }

}
