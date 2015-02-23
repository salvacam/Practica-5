<?php

class ModeloProducto {

    //Implementamos los métodos que necesitamos para trabajar con la persona
    private $bd;
    private $tabla = "tienda_producto";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    function add(Producto $objeto) {
        $sql = "insert into $this->tabla values (null, :nombre, :descripcion,"
                . " :precio, :iva, null);";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico(); //return 0 si no fuera autonumerico        
    }
    
    function delete(Producto $objeto) {
        $sql = "delete from $this->tabla where id=:id;";
        $parametros["id"] = $objeto->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    function deletePorId($id) {
        return $this->delete(new Plato($id));
    }
    
    function borrar($id, $nombre, $descripcion = "") {
        $sql = "update $this->tabla set nombre=:nombre, descripcion=:descripcion"
                . " where id=:id;";
        $parametros["nombre"] = $nombre;
        $parametros["descripcion"] = " ";
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    //clave principal autonumérica
    function edit(Producto $objeto) {
        $sql = "update $this->tabla set nombre=:nombre, descripcion=:descripcion,"
                . "precio=:precio, iva=:iva, imagen=:imagen where id=:id;";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $parametros["imagen"] = $objeto->getImagen();
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
        $sql = "select * from $this->tabla where id=:id;";
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $producto = new Producto();
            $producto->set($this->bd->getFila());
            return $producto;
        }
        return null;
    }

    /*
      function getNombre($nombre) {
      $sql = "select * from $this->tabla where nombre=:nombre;";
      $parametros["nombre"] = $nombre;
      $r = $this->bd->setConsulta($sql, $parametros);
      if ($r) {
      $producto = new Producto();
      $producto->set($this->bd->getFila());
      return $producto;
      }
      return null;
      }
     */

    function getList($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $principio = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderBy limit $principio, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $producto = new Producto();
                $producto->set($fila);
                $list[] = $producto;
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
                $producto = new Producto();
                $producto->set($fila);
                $list[] = $producto;
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
            $objeto = new Producto();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

}
