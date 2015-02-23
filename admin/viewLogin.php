<?php
require '../require/comun.php';

if (Leer::get("error") != null) {
    $error = Leer::get("error");
}
?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A layout example that shows off a responsive email layout.">
        <title>Tienda Deportes</title>    
        <script src="../js/vendor/alertify.js"></script>
        <link rel="stylesheet" href="../css/vendor/pure-min.css">
        <link rel="stylesheet" href="../css/vendor/email.css">
        <link rel="stylesheet" href="../css/vendor/alertify.css">

    </head>

    <body>

        <div id="layout" class="content pure-g">
            <div id="nav" class="pure-u back">                
                <img src="../img/logo.png" id="logo" alt="logo" /> 
            </div>
            <div id="main" class="pure-u-1 back">
                <div class="email-content">
                    <div class="email-content-header pure-g">
                        <form action="phpLogin.php" method="POST" class="pure-form" id="formLogin"><br/>   <br/> 
                            <input type="text" name="nombre" value="" id="nombre" placeholder="nombre" required/><br/><br/> 
                            <input type="password" name="clave" value="" id="clave" placeholder="clave" required/><br/><br/> 
                            <input type="submit" class="pure-button pure-button-primary" value="Login" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
    if (Leer::get("error") != null) {
        $error = Leer::get("error");
        echo "<script>alertify.error('$error');</script>";
    }
    ?>

</html>

