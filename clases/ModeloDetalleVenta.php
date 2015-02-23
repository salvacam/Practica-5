<?php

class ModeloDetalleVenta {

    //Implementamos los métodos que necesitamos para trabajar con la persona
    private $bd;
    private $tabla = "tienda_detalleVenta";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    function add(DetalleVenta $objeto) {
        $sql = "insert into $this->tabla values (null, :idVenta, :idProducto,"
                . " :cantidad, :precio, :iva);";
        $parametros["idVenta"] = $objeto->getIdVenta();
        $parametros["idProducto"] = $objeto->getIdProducto();
        $parametros["cantidad"] = $objeto->getCantidad();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico(); //return 0 si no fuera autonumerico        
    }

    function delete(DetalleVenta $objeto) {
        $sql = "delete from $this->tabla where id=:id;";
        $parametros["id"] = $objeto->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    function deletePorId($id) {
        return $this->delete(new DetalleVenta($id));
    }

    //clave principal autonumérica
    function edit(DetalleVenta $objeto) {
        $sql = "update $this->tabla set idVenta=:idVenta, idProducto=:idProducto,"
                . "cantidad=:cantidad, precio=:precio, iva=:iva where id=:id;";
        $parametros["idVenta"] = $objeto->getidVenta();
        $parametros["idProducto"] = $objeto->getidProducto();
        $parametros["cantidad"] = $objeto->getCantidad();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["iva"] = $objeto->getIva();
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
            $detalleVenta = new DetalleVenta();
            $detalleVenta->set($this->bd->getFila());
            return $detalleVenta;
        }
        return null;
    }

    /* puede que valga pero devolviendo un array
      //le paso el idVenta y me devuelve el objeto completo
      function getVenta($idVenta) {
      $sql = "select * from $this->tabla where idVenta=:idVenta;";
      $parametros["idVenta"] = $idVenta;
      $r = $this->bd->setConsulta($sql, $parametros);
      if ($r) {
      $detalleVenta = new DetalleVenta();
      $detalleVenta->set($this->bd->getFila());
      return $detalleVenta;
      }
      return null;
      }

      //le paso el idProducto y me devuelve el objeto completo
      function getProducto($idProducto) {
      $sql = "select * from $this->tabla where idProducto=:idProducto;";
      $parametros["idProducto"] = $idProducto;
      $r = $this->bd->setConsulta($sql, $parametros);
      if ($r) {
      $detalleVenta = new DetalleVenta();
      $detalleVenta->set($this->bd->getFila());
      return $detalleVenta;
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
                $detalleVenta = new DetalleVenta();
                $detalleVenta->set($fila);
                $list[] = $detalleVenta;
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
                $detalleVenta = new DetalleVenta();
                $detalleVenta->set($fila);
                $list[] = $detalleVenta;
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
            $objeto = new DetalleVenta();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    function getListSinPaginarJSON($condicion = "1=1", $parametros = array(), $orderby = "1") {
        $sql = "select from " . $this->tabla . " where $condicion order by $orderby ;";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new DetalleVenta();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    function getListSinPaginarProdJSON($condicion = "1=1", $parametros = array(), $orderby = "1") {
        $sql = "select tienda_producto.nombre," . $this->tabla . ".cantidad, " . 
                $this->tabla . ".precio, " . $this->tabla . ".iva "
                . "from " . $this->tabla . ", tienda_producto "
                . "where tienda_producto.id = idProducto and $condicion order by $orderby ;";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $resp = "{ ";
            foreach( $fila as $key => $value) {
                $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';                
            }
            $resp = substr($resp, 0, -1) . "},";
            $r.= $resp;
            
            
            /*$objeto = new DetalleVenta();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";*/
        }
        //$r = substr($r, 0, -1) . "]";
        $r = substr($r, 0, -1) . "]";
        //$r .= " ]";
        return $r;
    }

}
