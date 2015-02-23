<?php

class Leer {

    public static function get($param, $filtrar = true) {
        if (isset($_GET[$param])) {
            $v = $_GET[$param];
            if (is_array($v)) {
                return Leer::leerArray($v);
            } else {
                if ($filtrar) {
                    return Leer::limpiar($v);
                } else {
                    return $v;
                }
            }
        } else {
            return null;
        }
    }

    public static function isArray($param) {
        if (isset($_GET[$param])) {
            return is_array($_GET[$param]);
        } elseif (isset($_POST[$param])) {
            return is_array($_POST[$param]);
        }
        return null;
    }

    private static function leerArray($param, $filtrar = true) {
        $array = array();
        foreach ($param as $key => $value) {
            if ($filtrar) {
                $array[] = Leer::limpiar($value);
            } else {
                $array[] = $value;
            }
        }
        return $array;
    }

    private static function limpiar($param) {
        return trim(htmlspecialchars($param));
    }

    public static function post($param, $filtrar = true) {
        if (isset($_POST[$param])) {
            $v = $_POST[$param];
            if (is_array($v)) {
                return Leer::leerArray($v);
            } else {
                if ($filtrar) {
                    return Leer::limpiar($v);
                } else {
                    return $v;
                }
            }
        } else {
            return null;
        }
    }

    public static function request($param, $filtrar = true) {
        if (self::isGet()) {
            return Leer::get($param, $filtrar);
        }
        return Leer::post($param, $filtrar);
    }

    public static function getMetodo() {
        return $_SERVER["REQUEST_METHOD"];
    }

    public static function isGet() {
        return self::getMetodo() == "GET";
    }

    public static function isPost() {
        return self::getMetodo() == "POST";
    }

}
