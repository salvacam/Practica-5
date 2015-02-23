<?php
require '../require/comun.php';
$sesion->autentificado("viewLogin.php");

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
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
                        <div class="pure-u-1 back">                        
                            <a href="index.php" class="secondary-button pure-button" id="desconectar">Volver</a>
                        </div>
                    </div>
                    <div class="email-content-body pure-u-1 back">       
                        <div class="pure-u">
                            <h2>Añadir Producto</h2>
                            <form method="POST" action="phpInsert.php" id="formulario" enctype="multipart/form-data">
                                <label for="nombre">Nombre</label><br/>
                                <input type="text" name="nombre" id="nombre"/><br/>
                                <label for="descripcion">Descripcion</label> <br/>
                                <textarea name="descripcion" id="descripcion"></textarea><br/>
                                <label for="precio">Precio</label><br/>
                                <input type="text" name="precio" id="precio"/><br/>
                                <label for="iva">Iva</label><br/>
                                <select name="iva" id="iva">
                                    <option value="21">21%</option>
                                    <option value="10">10%</option>
                                    <option value="7">7%</option>
                                    <option value="4">4%</option>
                                    <option value="0">0%</option>
                                </select>  <br/><br/>
                                <label for="foto">Selecciona la imagen</label>
                                <input type="file" id="foto" name="foto" accept="image/*">
                                <div id="lista"></div>
                                <br/>
                                <input type="button" value="Aceptar" id="aceptar" class="primary-button pure-button"/>                                
                                <input type="reset" id="reset" value="Limpiar" class="primary-button button-warning pure-button"/>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </body>
    <script>
        var precio = document.getElementById("precio");
        precio.addEventListener("keypress", function (e) {
            var codigo = e.charCode || e.keyCode;
            if (codigo < 32 || codigo == 37 || codigo == 38 || codigo == 39 || codigo == 40 || codigo == 46) {
                return;
            }
            var texto = String.fromCharCode(codigo);

            //var punto = false;
            var permitidos = "0123456789";
            if (permitidos.indexOf(texto) === -1 && codigo != 46) {
                // Es un carácter no permitido
                if (e.preventDefault) {
                    e.preventDefault();
                }
                return false;
            } else if (e.target.value.indexOf('.') >= 0 && codigo == 46) {
                // Ya tiene un punto
                if (e.preventDefault) {
                    e.preventDefault();
                }
                return false;
            }
        });
        var nombre = document.getElementById("nombre");
        var descripcion = document.getElementById("descripcion");
        var aceptar = document.getElementById("aceptar");
        aceptar.addEventListener("click", function () {
            if (descripcion.value.trim().length <5 || nombre.value.trim() == "" || precio.value.trim() == "") {
                alertify.error("Valores no validos");
            } else {
                document.getElementById("formulario").submit();
            }
        });
        document.getElementById('foto').addEventListener('change', function (evt) {
            var files = evt.target.files; // FileList object
            var lista = document.getElementById('lista');
            lista.innerHTML = "";
            // Loop through the FileList and render image files as thumbnails.
            for (var i = 0, f; f = files[i]; i++) {

                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function (theFile) {
                    return function (e) {
                        // Render thumbnail.
                        var span = document.createElement('span');
                        span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
                        lista.insertBefore(span, null);
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        });

    </script>
</html>
