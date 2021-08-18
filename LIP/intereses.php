<?php
ob_start();
?>
<?php
require 'metodos/procesos.php';
$validacion = new Validar();
$validacion->existente();
$validacion->regenerar();
if (isset($_REQUEST['guardar'])) {
    $guardar = new Intereses();
    $guardar->guardar($_SESSION['cedula_usuario']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- styles -->
    <link rel="stylesheet" href="customStyleCss/intereses.css">

    <!-- Scripts -->
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <script src="javaScript/app.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">


    <title>Document</title>
</head>

<body>
    <nav class="menu">
        <label class="logo"><img src="img/login/logo-kometa-trans.png" alt="" width="150px"></label>
        <ul class="menu_items">
            <li class="">
                <a href="metodos/cerrarSesion.php" style="color: #fff;font-size: 20px;">Cerrar Sesión</a>
            </li>
        </ul>
        <span class="btn_menu">
            <i class="fa fa-bars"><img src="img/home/bars.png" alt=""></i>
        </span>


    </nav>
    <div class="principal">
        <div class="padre">
            <div class="hijo titulo">
                <h1>¡Que te gustaría aprender!</h1>
            </div>
        </div>

        <div class="padre">
            <div class="hijo"><button id="escrituraB" class="button" onclick="guardar('escrituraB','escritura')">Escritura</button></div>

            <div class="hijo"><button id="tecnologiaB" class="button" onclick="guardar('tecnologiaB','tecnologia')">Tecnología</button></div>

            <div class="hijo"><button id="poesiaB" class="button" onclick="guardar('poesiaB','poesia')">Poesía</button></div>



        </div>
        <div class="padre">
            <div class="hijo"><button id="seguridadB" class="button" onclick="guardar('seguridadB','seguridad')">Seguridad</button></div>

            <div class="hijo"><button id="webB" class="button" onclick="guardar('webB','web')">Diseño Web</button></div>

            <div class="hijo"><button id="blockchainB" class="button" onclick="guardar('blockchainB','blockchain')">Blockchain</button></div>

        </div>
        <form action="intereses.php" method="POST" class="animate__animated animate__fadeInDown">
            <input type="hidden" id="escritura" name="escritura" value="0">
            <input type="hidden" id="tecnologia" name="tecnologia" value="0">
            <input type="hidden" id="poesia" name="poesia" value="0">
            <input type="hidden" id="seguridad" name="seguridad" value="0">
            <input type="hidden" id="web" name="web" value="0">
            <input type="hidden" id="blockchain" name="blockchain" value="0">
            <div class="padre">
                <div class="hijo"><button type="submit" name="guardar" class="button">Continuar</button></div>
            </div>
        </form>

    </div>
    <script>
        function guardar(idB, id) {
            if (document.getElementById(id).value == "0") {
                document.getElementById(idB).style.background = "#2b99ff";
                document.getElementById(idB).style.color = "white";
                document.getElementById(id).value = "1";
            } else {
                document.getElementById(idB).style.background = "rgb(220, 220, 220)";
                document.getElementById(idB).style.color = "black";
                document.getElementById(id).value = "0";
            }
        }
    </script>
</body>

</html>

<?php

ob_end_flush();
?>