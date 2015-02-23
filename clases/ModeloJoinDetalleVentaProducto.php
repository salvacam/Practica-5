<?php

class ModeloJoinDetalleVentaProducto {

    private $bd = null;
    private $tablaIzq = "tienda_detalleVenta";
    private $tablaDer = "tienda_producto";

    function __construct($bd) {
        $this->bd = $bd;
    }

    function count($condicion = "") {
        $this->bd->setConsulta("select count(*)
                from $this->tablaIzq i 
                join $this->tablaDer d 
                on i.idProducto = d.id;");
        $fila = $this->bd->getFila();
        return $fila[0];
    }

    function getListPagina($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                join $this->tablaDer d 
                on i.idProducto = d.id
                where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaSinPaginar($condicion = "1=1", $parametros = array(), $orderby = "1") {
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                join $this->tablaDer d 
                on i.idProducto = d.id
                where $condicion order by $orderby;";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaIzquierda($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                join $this->tablaDer d 
                on i.idProducto = d.id
                where d.id is null
                and $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaDerecha($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                join $this->tablaDer d 
                on i.idProducto = d.id
                where i.idProducto is null
                and $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaIzquierdaCompleto($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                left join $this->tablaDer d 
                on i.idProducto = d.id
                where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaDerechaCompleto($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select pi.*, d.*
                from $this->tablaIzq i 
                right join $this->tablaDer d 
                on i.idProducto = d.id
                where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaInverso($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                left join $this->tablaDer d 
                on i.idProducto = d.id
                where d.id is null
                union
                select i.*, d.*
                from $this->tablaIzq i 
                right join $this->tablaDer d 
                on i.idProducto = d.id
                where i.idProducto is null
                and $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    function getListPaginaCompleto($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select i.*, d.*
                from $this->tablaIzq i 
                left join $this->tablaDer d 
                on i.idProducto = d.id
                union
                select i.*, d.*
                from $this->tablaIzq i 
                right join $this->tablaDer d 
                on i.idProducto = d.id
                where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto1 = new DetalleVenta();
            $objeto1->set($fila);
            $objeto2 = new Producto();
            $objeto2->set($fila, 6);
            $objeto = new JoinDetalleVentaProducto($objeto1, $objeto2);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

}
