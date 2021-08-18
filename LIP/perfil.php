<?php
ob_start();
?>
<?php
require 'metodos/procesos.php';
$validacion = new Validar();
$validacion->existente();

if (isset($_REQUEST['Actualizar'])) {
    $actualizar = new Perfil();
    $actualizar->guardar($_POST['cedula']);
    $validacion->regenerar();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link rel="stylesheet" href="customStyleCss/perfil.css">
    <link rel="stylesheet" href="customStyleCss/homeStyles.css">
    <!-- Scripts -->
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <script src="javaScript/app.js"></script>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- animaciones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="Css/animated.css">



    <title>perfil</title>
</head>

<body>


    <!-- <div class="animate__animated animate__fadeIn"> -->
    <nav class="menu">
        <label class="logo"><img src="img/login/logo-kometa-trans.png" alt="" width="150px"></label>
        <ul class="menu_items">
            <li class="active icon">

                <a href="home.php"><img src="img/home/home.png" alt=""></a>
            </li>
            <li class="icon">
                <a href="#"><img src="img/home/lupa.png" alt=""></a>
            </li>
            <li class="icon">
                <a href="#"><img src="img/home/notificacion.png" alt=""></a>
            </li>
            <li class="">
                <a href="#"><img src="img/home/mujer-final.png" alt="" width="40px" align="center">Juana de arco</a>
            </li>
            <li class="">
                <a href="metodos/cerrarSesion.php" style="color: #fff;font-size: 20px;">Cerrar Sesión</a>
            </li>


        </ul>
        <span class="btn_menu">
            <i class="bars"><img src="img/home/bars.png" alt=""></i>
        </span>
        </div>
    </nav>


    <div class="contenedor animate__animated animate__fadeInDown">

        <div class="contenedor1">
            <img src="img/home/mujer-final.png" alt="" align="left">
            <h1>Juana de arco</h1>
            <h3>lider</h3>
        </div>


        <div class="contenedor1 caja1">
            <h2><a href="perfil.php">Mi perfil</a></h2>
            <h2><a href="miplan.php">Mi plan</a></h2>
            <h2><a href="competencias.php">Competencias</a></h2>
            <h2><a href="postulaciones.php">Posulaciones</a></h2>
            <h2><a href="">Logros</a></h2>
            <h2><a href="">Informes</a></h2>

            <?php
            $perfil = new Perfil();
            $perfil->datosPerfil($_SESSION['cedula_usuario']);
            ?>
        </div>


    </div>


</body>

</html>