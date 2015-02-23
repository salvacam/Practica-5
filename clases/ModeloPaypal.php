<?php

class ModeloPaypal {

    //Implementamos los métodos que necesitamos para trabajar con la persona
    private $bd;
    private $tabla = "tienda_paypal";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    function add(Paypal $objeto) {
        $sql = "insert into $this->tabla values (null, :idVenta, "
                . ":mc_gross, :protection_eligibility, :address_status, :payer_id,"
                . ":tax, :address_street, :payment_date, :payment_status, :charset, :address_zip, "
                . ":first_name, :mc_fee, :address_country_code, :address_name, :notify_version, :custom,"
                . ":payer_status, :business, :address_country, :address_city, :quantity, "
                . ":verify_sign, :payer_email, :txn_id, :payment_type, :last_name, :address_state, "
                . ":receiver_email, :payment_fee, :receiver_id, :txn_type, :item_name, :mc_currency, :item_number, "
                . ":residence_country, :test_ipn, :handling_amount, :transaction_subject, "
                . ":payment_gross, :shipping, :ipn_track_id, :estatus, :pago);";
        var_dump($sql);
        $parametros["idVenta"] = $objeto->getIdVenta();
        $parametros["mc_gross"] = $objeto->getMc_gross();
        $parametros["protection_eligibility"] = $objeto->getProtection_eligibility();
        $parametros["address_status"] = $objeto->getAddress_status();
        $parametros["payer_id"] = $objeto->getPayer_id();
        $parametros["tax"] = $objeto->getTax();
        $parametros["address_street"] = $objeto->getAddress_street();
        $parametros["payment_date"] = $objeto->getPayment_date();
        $parametros["payment_status"] = $objeto->getPayment_status();
        $parametros["charset"] = $objeto->getCharset();
        $parametros["address_zip"] = $objeto->getAddress_zip();
        $parametros["first_name"] = $objeto->getFirst_name();
        $parametros["mc_fee"] = $objeto->getMc_fee();
        $parametros["address_country_code"] = $objeto->getAddress_country_code();
        $parametros["address_name"] = $objeto->getAddress_name();
        $parametros["notify_version"] = $objeto->getNotify_version();
        $parametros["custom"] = $objeto->getCustom();
        $parametros["payer_status"] = $objeto->getPayer_status();
        $parametros["business"] = $objeto->getBusiness();
        $parametros["address_country"] = $objeto->getAddress_country();
        $parametros["address_city"] = $objeto->getAddress_city();
        $parametros["quantity"] = $objeto->getQuantity();
        $parametros["verify_sign"] = $objeto->getVerify_sign();
        $parametros["payer_email"] = $objeto->getPayer_email();
        $parametros["txn_id"] = $objeto->getTxn_id();
        $parametros["payment_type"] = $objeto->getPayment_type();
        $parametros["last_name"] = $objeto->getLast_name();
        $parametros["address_state"] = $objeto->getAddress_state();
        $parametros["receiver_email"] = $objeto->getReceiver_email();
        $parametros["payment_fee"] = $objeto->getPayment_fee();
        $parametros["receiver_id"] = $objeto->getReceiver_id();
        $parametros["txn_type"] = $objeto->getTxn_type();
        $parametros["item_name"] = $objeto->getItem_name();
        $parametros["mc_currency"] = $objeto->getMc_currency();
        $parametros["item_number"] = $objeto->getItem_number();
        $parametros["residence_country"] = $objeto->getResidence_country();
        $parametros["test_ipn"] = $objeto->getTest_ipn();
        $parametros["handling_amount"] = $objeto->getHandling_amount();
        $parametros["transaction_subject"] = $objeto->getTransaction_subject();
        $parametros["handling_amount"] = $objeto->getHandling_amount();
        $parametros["transaction_subject"] = $objeto->getTransaction_subject();
        $parametros["payment_gross"] = $objeto->getPayment_gross();
        $parametros["shipping"] = $objeto->getShipping();
        $parametros["ipn_track_id"] = $objeto->getIpn_track_id();
        $parametros["estatus"] = $objeto->getEstatus();
        $parametros["pago"] = $objeto->getPago();
        //var_dump($parametros);
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico(); //return 0 si no fuera autonumerico        
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
            $venta = new Paypal();
            $venta->set($this->bd->getFila());
            return $venta;
        }
        return null;
    }

    function getVenta($id) {
        $sql = "select * from $this->tabla where idVenta=:id;";
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $venta = new Paypal();
            $valor = $this->bd->getFila();
            if($valor){
                $venta->set($valor);
                return $venta;            
            } else {
                return null;        
            }
        }
        return null;
    }

    function getList($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $principio = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderBy limit $principio, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $paypal = new Paypal();
                $paypal->set($fila);
                $list[] = $paypal;
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
                $paypal = new Paypal();
                $paypal->set($fila);
                $list[] = $paypal;
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
            $objeto = new Paypal();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

}
