<?php

class ModeloVenta {

    //Implementamos los métodos que necesitamos para trabajar con la persona
    private $bd;
    private $tabla = "tienda_venta";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    function add(Venta $objeto) {
        $sql = "insert into $this->tabla values (null, null, :nombre,"
                . " :direccion, :pago);";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["direccion"] = $objeto->getDireccion();
        $parametros["pago"] = $objeto->getPago();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico(); //return 0 si no fuera autonumerico        
    }

    function delete(Venta $objeto) {
        $sql = "delete from $this->tabla where id=:id;";
        $parametros["id"] = $objeto->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    function deletePorId($id) {
        return $this->delete(new Venta($id));
    }

    //clave principal autonumérica
    function edit(Venta $objeto) {
        $sql = "update $this->tabla set pago=:pago where id=:id;";
        $parametros["pago"] = $objeto->getPago();
        $parametros["id"] = $objeto->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    function count($condicion = "1=1", $parametros = array()) {
        $sql = "select count(*) from $this->tabla where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            //return $this->bd->getFila()[0];
            return $this->bd->getFila();
        }
        return -1;
    }

    //le paso el id y me devuelve el objeto completo
    function get($id) {
        $sql = "select id, DATE_FORMAT(`fechaHora`,'%d-%m-%Y / %H:%i,%s'), "
                . "nombre, direccion, pago from $this->tabla where id=:id;";
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $venta = new Venta();
            $venta->set($this->bd->getFila());
            return $venta;
        }
        return null;
    }

    function getList($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $principio = $pagina * $rpp;
        $sql = "select id, DATE_FORMAT(`fechaHora`,'%d-%m-%Y / %H:%i,%s'), "
                . "nombre, direccion, pago "
                . "from $this->tabla where $condicion order by $orderBy limit $principio, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $venta = new Venta();
                $venta->set($fila);
                $list[] = $venta;
            }
        } else {
            return null;
        }
        return $list;
    }

    function getListSinPaginar($condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $sql = "select * from $this->tabla where $condicion order by $orderBy";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $venta = new Venta();
                $venta->set($fila);
                $list[] = $venta;
            }
        } else {
            return null;
        }
        return $list;
    }

    function getJSON($id) {
        return $this->get($id)->getJSON();
    }

    function getListJSON($pagina = 0, $rpp = 3, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from "
                . $this->tabla .
                " where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Venta();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    function getListSinPaginarJSON($condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $sql = "select id, DATE_FORMAT(`fechaHora`,'%d-%m-%Y / %H:%i,%s'), "
                . "nombre, direccion, pago "
                . "from $this->tabla where $condicion order by $orderBy";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $venta = new Venta();
            $venta->set($fila);            
            $r .= $venta->getJSON() . ",";        
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

}
