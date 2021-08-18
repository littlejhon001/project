<?php
ob_start();
?>
<?php
require 'metodos/procesos.php';
$validacion = new Validar();
$validacion->existente();
$validacion->regenerar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- styles -->
    <link rel="stylesheet" href="customStyleCss/homeStyles.css">

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
        <label class="logo"><a href="home.html"> <img src="img/login/logo-kometa-trans.png" alt="" width="150px"></a></label>
        <ul class="menu_items">
            <li class="active icon">

                <a href="#"><img src="img/home/home.png" alt=""></a>
            </li>
            <li class="icon">
                <a href="#"><img src="img/home/lupa.png" alt=""></a>
            </li>
            <li class="icon">
                <a href="#"><img src="img/home/notificacion.png" alt=""></a>
            </li>
            <li class="">
                <a href="perfil.php"><?php echo $_SESSION['nombres_usuario']; ?><img src="img/home/mujer-final.png" alt="" width="40px" align="center"></a>
            </li>
            <li class="">
                <a href="metodos/cerrarSesion.php" style="color: #fff;font-size: 20px;">Cerrar Sesión</a>
            </li>


        </ul>
        <span class="btn_menu">
            <i class="fa fa-bars"><img src="img/home/bars.png" alt=""></i>
        </span>






    </nav>
    <div class="box1">

        <div class="box2 box3">
            <div class="box5"><img src="img/home/mujer-final.png" alt="" width="100px" align="left">
                <h3><?php echo $_SESSION['nombres_usuario']; ?></h3>
                <p>lider</p>
                <p>progresbar</p>
            </div>
            <div class="box5">
                <h2>Mi plan</h2>
            </div>
            <div class="box5">
                <h2>
                    Bienestar
                </h2>
            </div>
        </div>
        <div class="box2 box4">

            <div class="box6">
                <h2>Aprender</h2>
            </div>
            <div class="box6">
                <h2>Novedades</h2>
            </div>


        </div>


    </div>

</body>

</html>

<?php
ob_end_flush();
?>