<?php

class Paypal {

    private $id;
    private $idVenta;
    //
    private $mc_gross;
    private $protection_eligibility;
    private $address_status;
    private $payer_id;
    private $tax;
    private $address_street;
    private $payment_date;
    private $payment_status;
    private $charset;
    private $address_zip;
    private $first_name;
    private $mc_fee;
    private $address_country_code;
    private $address_name;
    private $notify_version;
    private $custom;
    private $payer_status;
    private $business;
    private $address_country;
    private $address_city;
    private $quantity;
    private $verify_sign;
    private $payer_email;
    private $txn_id;
    private $payment_type;
    private $last_name;
    private $address_state;
    private $receiver_email;
    private $payment_fee;
    private $receiver_id;
    private $txn_type;
    private $item_name;
    private $mc_currency;
    private $item_number;
    private $residence_country;
    private $test_ipn;
    private $handling_amount;
    private $transaction_subject;
    private $payment_gross;
    private $shipping;
    private $ipn_track_id;
    //
    private $estatus;
    private $pago;
    
    function __construct() {
        $this->id = null;
        $this->idVenta = null;
        $this->mc_gross = null;
        $this->protection_eligibility = null;
        $this->address_status = null;
        $this->payer_id = null;
        $this->tax = null;
        $this->address_street = null;
        $this->payment_date = null;
        $this->payment_status = null;
        $this->charset = null;
        $this->address_zip = null;
        $this->first_name = null;
        $this->mc_fee = null;
        $this->address_country_code = null;
        $this->address_name = null;
        $this->notify_version = null;
        $this->custom = null;
        $this->payer_status = null;
        $this->business = null;
        $this->address_country = null;
        $this->address_city = null;
        $this->quantity = null;
        $this->verify_sign = null;
        $this->payer_email = null;
        $this->txn_id = null;
        $this->payment_type = null;
        $this->last_name = null;
        $this->address_state = null;
        $this->receiver_email = null;
        $this->payment_fee = null;
        $this->receiver_id = null;
        $this->txn_type = null;
        $this->item_name = null;
        $this->mc_currency = null;
        $this->item_number = null;
        $this->residence_country = null;
        $this->test_ipn = null;
        $this->handling_amount = null;
        $this->transaction_subject = null;
        $this->payment_gross = null;
        $this->shipping = null;
        $this->ipn_track_id = null;
        $this->estatus = null;
        $this->pago = null;
    }

    /*
    function __construct($id = null, $idVenta = null, $verificado = null, $mc_gross = null, 
            $protection_eligibility = null, $address_status = null, $payer_id = null, $tax = null, 
            $address_street = null, $payment_date = null, $payment_status = null, $charset = null, 
            $address_zip = null, $first_name = null, $mc_fee = null, $address_country_code = null, 
            $address_name = null, $notify_version = null, $custom = null, $payer_status = null, 
            $business = null, $address_country = null, $address_city = null, $quantity = null,
            $verify_sign = null, $payer_email = null, $txn_id = null, $payment_type = null, 
            $last_name = null, $address_state = null, $receiver_email = null, $payment_fee = null, 
            $receiver_id = null, $txn_type = null, $item_name = null, $mc_currency = null, 
            $item_number = null, $residence_country = null, $test_ipn = null, $handling_amount = null, 
            $transaction_subject = null, $payment_gross = null, $shipping = null, $ipn_track_id = null, 
            $estatus = null, $pago = null) {
        $this->id = $id;
        $this->idVenta = $idVenta;
        $this->verificado = $verificado;
        $this->mc_gross = $mc_gross;
        $this->protection_eligibility = $protection_eligibility;
        $this->address_status = $address_status;
        $this->payer_id = $payer_id;
        $this->tax = $tax;
        $this->address_street = $address_street;
        $this->payment_date = $payment_date;
        $this->payment_status = $payment_status;
        $this->charset = $charset;
        $this->address_zip = $address_zip;
        $this->first_name = $first_name;
        $this->mc_fee = $mc_fee;
        $this->address_country_code = $address_country_code;
        $this->address_name = $address_name;
        $this->notify_version = $notify_version;
        $this->custom = $custom;
        $this->payer_status = $payer_status;
        $this->business = $business;
        $this->address_country = $address_country;
        $this->address_city = $address_city;
        $this->quantity = $quantity;
        $this->verify_sign = $verify_sign;
        $this->payer_email = $payer_email;
        $this->txn_id = $txn_id;
        $this->payment_type = $payment_type;
        $this->last_name = $last_name;
        $this->address_state = $address_state;
        $this->receiver_email = $receiver_email;
        $this->payment_fee = $payment_fee;
        $this->receiver_id = $receiver_id;
        $this->txn_type = $txn_type;
        $this->item_name = $item_name;
        $this->mc_currency = $mc_currency;
        $this->item_number = $item_number;
        $this->residence_country = $residence_country;
        $this->test_ipn = $test_ipn;
        $this->handling_amount = $handling_amount;
        $this->transaction_subject = $transaction_subject;
        $this->payment_gross = $payment_gross;
        $this->shipping = $shipping;
        $this->ipn_track_id = $ipn_track_id;
        $this->estatus = $estatus;
        $this->pago = $pago;
    }
*/
    function set($array) {
        foreach ($array as $indice => $valor) {
            $this->$indice = $valor;
        }
    }
    
    function setNoId($array) {
        //$this->id
        //$this->idVenta = $datos[0 + $inicio];
        //$this->verificado = $datos[1 + $inicio];
        foreach ($array as $indice => $valor) {
            $this->$indice = $valor;
        }
        /*$this->mc_gross = $array["mc_gross"];
        $this->protection_eligibility = $array[""];
        $this->address_status = $array["address_status"];
        $this->payer_id = $array["payer_id"];
        $this->tax = $array["tax"];
        $this->address_street = $datos[5 + $inicio];
        $this->payment_date = $datos[6 + $inicio];
        $this->payment_status = $datos[7 + $inicio];
        $this->charset = $datos[8 + $inicio];
        $this->address_zip = $datos[9 + $inicio];
        $this->first_name = $datos[10 + $inicio];
        $this->mc_fee = $datos[11 + $inicio];
        $this->address_country_code = $datos[12 + $inicio];
        $this->address_name = $datos[13 + $inicio];
        $this->notify_version = $datos[14 + $inicio];
        $this->custom = $datos[15 + $inicio];
        $this->payer_status = $datos[16 + $inicio];
        $this->business = $datos[17 + $inicio];
        $this->address_country = $datos[18 + $inicio];
        $this->address_city = $datos[19 + $inicio];
        $this->quantity = $datos[20 + $inicio];
        $this->verify_sign = $datos[21 + $inicio];
        $this->payer_email = $datos[22 + $inicio];
        $this->txn_id = $datos[23 + $inicio];
        $this->payment_type = $datos[24 + $inicio];
        $this->last_name = $datos[25 + $inicio];
        $this->address_state = $datos[26 + $inicio];
        $this->receiver_email = $datos[27 + $inicio];
        $this->payment_fee = $datos[28 + $inicio];
        $this->receiver_id = $datos[29 + $inicio];
        $this->txn_type = $datos[30 + $inicio];
        $this->item_name = $datos[31 + $inicio];
        $this->mc_currency = $datos[32 + $inicio];
        $this->item_number = $datos[33 + $inicio];
        $this->residence_country = $datos[34 + $inicio];
        $this->test_ipn = $datos[35 + $inicio];
        $this->handling_amount = $datos[36 + $inicio];
        $this->transaction_subject = $datos[37 + $inicio];
        $this->payment_gross = $datos[38 + $inicio];
        $this->shipping = $datos[39 + $inicio];
        $this->ipn_track_id = $datos[40 + $inicio];
        $this->estatus = $datos[41 + $inicio];
        $this->pago = $datos[42 + $inicio];*/
    }

    public function __toString() {
        return "Paypal => Id: {$this->getId()} IdVenta: {$this->getIdVenta()} Total: {$this->getMc_gross()}"
        . " Estatus: {$this->getEstatus()} Pago: {$this->getPago()}";
    }

    function getId() {
        return $this->id;
    }

    function getIdVenta() {
        return $this->idVenta;
    }

    function getMc_gross() {
        return $this->mc_gross;
    }

    function getProtection_eligibility() {
        return $this->protection_eligibility;
    }

    function getAddress_status() {
        return $this->address_status;
    }

    function getPayer_id() {
        return $this->payer_id;
    }

    function getTax() {
        return $this->tax;
    }

    function getAddress_street() {
        return $this->address_street;
    }

    function getPayment_date() {
        return $this->payment_date;
    }

    function getPayment_status() {
        return $this->payment_status;
    }

    function getCharset() {
        return $this->charset;
    }

    function getAddress_zip() {
        return $this->address_zip;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getMc_fee() {
        return $this->mc_fee;
    }

    function getAddress_country_code() {
        return $this->address_country_code;
    }

    function getAddress_name() {
        return $this->address_name;
    }

    function getNotify_version() {
        return $this->notify_version;
    }

    function getCustom() {
        return $this->custom;
    }

    function getPayer_status() {
        return $this->payer_status;
    }

    function getBusiness() {
        return $this->business;
    }

    function getAddress_country() {
        return $this->address_country;
    }

    function getAddress_city() {
        return $this->address_city;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getVerify_sign() {
        return $this->verify_sign;
    }

    function getPayer_email() {
        return $this->payer_email;
    }

    function getTxn_id() {
        return $this->txn_id;
    }

    function getPayment_type() {
        return $this->payment_type;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getAddress_state() {
        return $this->address_state;
    }

    function getReceiver_email() {
        return $this->receiver_email;
    }

    function getPayment_fee() {
        return $this->payment_fee;
    }

    function getReceiver_id() {
        return $this->receiver_id;
    }

    function getTxn_type() {
        return $this->txn_type;
    }

    function getItem_name() {
        return $this->item_name;
    }

    function getMc_currency() {
        return $this->mc_currency;
    }

    function getItem_number() {
        return $this->item_number;
    }

    function getResidence_country() {
        return $this->residence_country;
    }

    function getTest_ipn() {
        return $this->test_ipn;
    }

    function getHandling_amount() {
        return $this->handling_amount;
    }

    function getTransaction_subject() {
        return $this->transaction_subject;
    }

    function getPayment_gross() {
        return $this->payment_gross;
    }

    function getShipping() {
        return $this->shipping;
    }

    function getIpn_track_id() {
        return $this->ipn_track_id;
    }

    function getEstatus() {
        return $this->estatus;
    }

    function getPago() {
        return $this->pago;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    function setMc_gross($mc_gross) {
        $this->mc_gross = $mc_gross;
    }

    function setProtection_eligibility($protection_eligibility) {
        $this->protection_eligibility = $protection_eligibility;
    }

    function setAddress_status($address_status) {
        $this->address_status = $address_status;
    }

    function setPayer_id($payer_id) {
        $this->payer_id = $payer_id;
    }

    function setTax($tax) {
        $this->tax = $tax;
    }

    function setAddress_street($address_street) {
        $this->address_street = $address_street;
    }

    function setPayment_date($payment_date) {
        $this->payment_date = $payment_date;
    }

    function setPayment_status($payment_status) {
        $this->payment_status = $payment_status;
    }

    function setCharset($charset) {
        $this->charset = $charset;
    }

    function setAddress_zip($address_zip) {
        $this->address_zip = $address_zip;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setMc_fee($mc_fee) {
        $this->mc_fee = $mc_fee;
    }

    function setAddress_country_code($address_country_code) {
        $this->address_country_code = $address_country_code;
    }

    function setAddress_name($address_name) {
        $this->address_name = $address_name;
    }

    function setNotify_version($notify_version) {
        $this->notify_version = $notify_version;
    }

    function setCustom($custom) {
        $this->custom = $custom;
    }

    function setPayer_status($payer_status) {
        $this->payer_status = $payer_status;
    }

    function setBusiness($business) {
        $this->business = $business;
    }

    function setAddress_country($address_country) {
        $this->address_country = $address_country;
    }

    function setAddress_city($address_city) {
        $this->address_city = $address_city;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function setVerify_sign($verify_sign) {
        $this->verify_sign = $verify_sign;
    }

    function setPayer_email($payer_email) {
        $this->payer_email = $payer_email;
    }

    function setTxn_id($txn_id) {
        $this->txn_id = $txn_id;
    }

    function setPayment_type($payment_type) {
        $this->payment_type = $payment_type;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setAddress_state($address_state) {
        $this->address_state = $address_state;
    }

    function setReceiver_email($receiver_email) {
        $this->receiver_email = $receiver_email;
    }

    function setPayment_fee($payment_fee) {
        $this->payment_fee = $payment_fee;
    }

    function setReceiver_id($receiver_id) {
        $this->receiver_id = $receiver_id;
    }

    function setTxn_type($txn_type) {
        $this->txn_type = $txn_type;
    }

    function setItem_name($item_name) {
        $this->item_name = $item_name;
    }

    function setMc_currency($mc_currency) {
        $this->mc_currency = $mc_currency;
    }

    function setItem_number($item_number) {
        $this->item_number = $item_number;
    }

    function setResidence_country($residence_country) {
        $this->residence_country = $residence_country;
    }

    function setTest_ipn($test_ipn) {
        $this->test_ipn = $test_ipn;
    }

    function setHandling_amount($handling_amount) {
        $this->handling_amount = $handling_amount;
    }

    function setTransaction_subject($transaction_subject) {
        $this->transaction_subject = $transaction_subject;
    }

    function setPayment_gross($payment_gross) {
        $this->payment_gross = $payment_gross;
    }

    function setShipping($shipping) {
        $this->shipping = $shipping;
    }

    function setIpn_track_id($ipn_track_id) {
        $this->ipn_track_id = $ipn_track_id;
    }

    function setEstatus($estatus) {
        $this->status = $estatus;
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
