create database bdphp default character set utf8 collate utf8_unicode_ci;
grant all on bdphp.* to userphp@localhost identified by 'clavephp';
flush privileges;

use bdphp;

CREATE TABLE IF NOT EXISTS tienda_producto (
    id int NOT NULL primary key auto_increment,
    nombre varchar(30) NOT NULL,
    descripcion varchar(200) NOT NULL,
    precio decimal(5,2) NOT NULL,
    iva tinyint(1) NOT NULL,
    imagen varchar(10) NULL
) ENGINE=InnoDB collate utf8_unicode_ci;   

CREATE TABLE IF NOT EXISTS tienda_venta (
    id int NOT NULL primary key auto_increment,
    fechaHora timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    nombre varchar(30) NOT NULL,
    direccion varchar(200) NOT NULL,
    pago enum('Si', 'No', 'Duda') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB collate utf8_unicode_ci;   

CREATE TABLE IF NOT EXISTS tienda_detalleVenta (
    id int NOT NULL primary key auto_increment,
    idVenta int NOT NULL,
    idProducto int NOT NULL,
    cantidad tinyint(1) NOT NULL,
    precio decimal(5,2) NOT NULL,
    iva tinyint(1) NOT NULL,
    FOREIGN KEY (idVenta) REFERENCES tienda_venta (id),   
    FOREIGN KEY (idProducto) REFERENCES tienda_producto (id)   
) ENGINE=InnoDB collate utf8_unicode_ci;   

CREATE TABLE IF NOT EXISTS tienda_user (
    nombre varchar(30) NOT NULL,
    clave varchar(40) NOT NULL 
) ENGINE=InnoDB collate utf8_unicode_ci;

insert into tienda_user values('root', sha1('toor'));

insert into tienda_producto values(null, 'raqueta', 'raqueta de tenis', 120.12, 21, "img.jpg");
insert into tienda_producto values(null, 'raqueta1', 'raqueta de tenis', 110.12, 21, "img.jpg");
insert into tienda_producto values(null, 'raqueta2', 'raqueta de tenis', 90.12, 21, "img.jpg");
insert into tienda_producto values(null, 'raqueta3', 'raqueta de tenis', 80.12, 21, "img.jpg");



CREATE TABLE IF NOT EXISTS tienda_paypal (
    id int NOT NULL primary key auto_increment,
    idVenta int NULL,
    mc_gross decimal(8,2) NULL,
    protection_eligibility varchar(50) NULL,
    address_status varchar(50) NULL,
    payer_id varchar(50) NULL,
    tax decimal(5,2) NULL,
    address_street varchar(200) NULL,
    payment_date varchar(50) NULL,
    payment_status varchar(50) NULL,
    charset varchar(50) NULL,
    address_zip varchar(50) NULL,
    first_name varchar(50) NULL,
    mc_fee decimal(5,2) NULL,
    address_country_code varchar(50) NULL,
    address_name varchar(50) NULL,
    notify_version decimal(5,2) NULL,
    custom varchar(50) NULL,
    payer_status varchar(50) NULL,
    business varchar(200) NULL,
    address_country varchar(50) NULL,
    address_city varchar(50) NULL,
    quantity int NULL,
    verify_sign varchar(200) NULL,
    payer_email varchar(200) NULL,
    txn_id varchar(50) NULL,
    payment_type varchar(50) NULL,
    last_name varchar(50) NULL,
    address_state varchar(50) NULL,
    receiver_email varchar(200) NULL,
    payment_fee varchar(50) NULL,
    receiver_id varchar(50) NULL,
    txn_type varchar(50) NULL,
    item_name varchar(50) NULL,
    mc_currency varchar(50) NULL,
    item_number varchar(50) NULL, 
    residence_country varchar(50) NULL,
    test_ipn varchar(50) NULL,
    handling_amount varchar(50) NULL,
    transaction_subject varchar(50) NULL,
    payment_gross varchar(50) NULL,
    shipping decimal(5,2) NULL,
    ipn_track_id varchar(50) NULL,    
    estatus varchar(50) NULL,
    pago varchar(50) NULL
) ENGINE=InnoDB collate utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS tienda_paypal (
    id int NOT NULL primary key auto_increment,
    idVenta int NULL,
    mc_gross varchar(50) NULL,
    protection_eligibility varchar(50) NULL,
    address_status varchar(50) NULL,
    payer_id varchar(50) NULL,
    tax varchar(50) NULL,
    address_street varchar(200) NULL,
    payment_date varchar(50) NULL,
    payment_status varchar(50) NULL,
    charset varchar(50) NULL,
    address_zip varchar(50) NULL,
    first_name varchar(50) NULL,
    mc_fee varchar(50) NULL,
    address_country_code varchar(50) NULL,
    address_name varchar(50) NULL,
    notify_version decimal(5,2) NULL,
    custom varchar(50) NULL,
    payer_status varchar(50) NULL,
    business varchar(200) NULL,
    address_country varchar(50) NULL,
    address_city varchar(50) NULL,
    quantity varchar(50) NULL,
    verify_sign varchar(200) NULL,
    payer_email varchar(200) NULL,
    txn_id varchar(50) NULL,
    payment_type varchar(50) NULL,
    last_name varchar(50) NULL,
    address_state varchar(50) NULL,
    receiver_email varchar(200) NULL,
    payment_fee varchar(50) NULL,
    receiver_id varchar(50) NULL,
    txn_type varchar(50) NULL,
    item_name varchar(50) NULL,
    mc_currency varchar(50) NULL,
    item_number varchar(50) NULL, 
    residence_country varchar(50) NULL,
    test_ipn varchar(50) NULL,
    handling_amount varchar(50) NULL,
    transaction_subject varchar(50) NULL,
    payment_gross varchar(50) NULL,
    shipping varchar(50) NULL,
    ipn_track_id varchar(50) NULL,    
    estatus varchar(50) NULL,
    pago varchar(50) NULL
) ENGINE=InnoDB collate utf8_unicode_ci;  