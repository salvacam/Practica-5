<?php

class Util {

    static function getEnlacesPaginacion($pagina, $total, $rpp = Configuracion::RPP, $url = "") { //pagina, los registros que hay, y los que muestra 
        $enlaces = array();
        $paginas = ceil($total / $rpp) - 1;
        if ($pagina < 0) {
            $pagina = 0;
        }
        if ($pagina > $paginas) {
            $pagina = $paginas;
        }
        $inicio = 0;
        $fin = $paginas;
        if (strpos($url, "?") !== false) {
            $url .= "&";
        } else {
            $url .= "?";
        }
        if ($pagina > 0 && $pagina < $paginas - 1) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 2, $paginas, $url);
            $enlaces["segundo"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["actual"] = "<span class='paginacion pure-button pure-button-active'>" . ($pagina + 1) . "</span>";
            $enlaces["cuarto"] = self::getEnlace($pagina + 1, $paginas, $url);
            $enlaces["quinto"] = self::getEnlace($pagina + 2, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        } else if ($pagina == 0) {
            $enlaces["inicio"] = "<span class='paginacion pure-button'>&Lt;</span>";
            $enlaces["anterior"] = "<span class='paginacion pure-button'>&lt;</span>";
            $enlaces["primero"] = "<span class='paginacion pure-button pure-button-active'>" . ($pagina + 1) . "</span>";
            $enlaces["segundo"] = self::getEnlace($pagina + 1, $fin, $url);
            $enlaces["actual"] = self::getEnlace($pagina + 2, $fin, $url);
            $enlaces["cuarto"] = self::getEnlace($pagina + 3, $fin, $url);
            $enlaces["quinto"] = self::getEnlace($pagina + 4, $fin, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $fin, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($pagina + 1 < $fin ? $fin : $pagina + 1, $fin, $url, '&Gt;');
        } else if ($pagina == 1) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["segundo"] = "<span class='paginacion pure-button pure-button-active'>" . ($pagina + 1) . "</span>";
            $enlaces["actual"] = self::getEnlace($pagina + 1, $paginas, $url);
            $enlaces["cuarto"] = self::getEnlace($pagina + 2, $paginas, $url);
            $enlaces["quinto"] = self::getEnlace($pagina + 3, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas - 1, $url, '&Gt;');
        } else if ($pagina == $paginas - 1) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 3, $paginas, $url);
            $enlaces["segundo"] = self::getEnlace($pagina - 2, $paginas, $url);
            $enlaces["actual"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["cuarto"] = "<span class='paginacion pure-button pure-button-active'>" . ($pagina + 1) . "</span>";
            $enlaces["quinto"] = self::getEnlace($pagina + 1, $paginas, $url);
            $enlaces["siguiente"] = self::getEnlace($pagina + 1, $paginas, $url, '&gt;');
            $enlaces["ultimo"] = self::getEnlace($fin, $paginas, $url, '&Gt;');
        } else if ($pagina == $paginas) {
            $enlaces["inicio"] = self::getEnlace($inicio, $paginas, $url, '&Lt;');
            $enlaces["anterior"] = self::getEnlace($pagina - 1, $paginas, $url, '&lt;');
            $enlaces["primero"] = self::getEnlace($pagina - 4, $paginas, $url);
            $enlaces["segundo"] = self::getEnlace($pagina - 3, $paginas, $url);
            $enlaces["actual"] = self::getEnlace($pagina - 2, $paginas, $url);
            $enlaces["cuarto"] = self::getEnlace($pagina - 1, $paginas, $url);
            $enlaces["quinto"] = "<span class='paginacion pure-button pure-button-active'>" . ($pagina + 1) . "</span>";
            $enlaces["siguiente"] = "<span class='paginacion pure-button'>&gt;</span>";
            $enlaces["ultimo"] = "<span class='paginacion pure-button'>&Gt;</span>";
        }
        return $enlaces;
    }

    private static function getEnlace($numero, $paginas, $url, $paginaUsuario = null) {
        if ($numero < 0) {
            if ($paginaUsuario == null) {
                return "";
            } else {
                return "<span class='paginacion pure-button'>" . $paginaUsuario . "</span>";
            }
        }
        if ($numero > $paginas) {
            if ($paginaUsuario == null) {
                return "";
            } else {
                return "<span class='paginacion pure-button'>" . $paginaUsuario . "</span>";
            }
        }
        if ($paginaUsuario == null) {
            $paginaUsuario = $numero + 1;
        }
        return "<a class='paginacion pure-button' href='" . $url . "pagina=$numero'>$paginaUsuario</a>";
    }

}