<?php

class ModeloUser {

    //Implementamos los métodos que necesitamos para trabajar con la persona
    private $bd;
    private $tabla = "tienda_user";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    function get($nombre, $clave) {
        $sql = "SELECT * FROM $this->tabla WHERE nombre=:nombre and clave=:clave;";
        $parametros["nombre"] = $nombre;
        $parametros["clave"] = sha1($clave);
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $user = new User();
            $user->set($this->bd->getFila());
            return $user;
        }
        return null;
    }

    
}
