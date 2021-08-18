<?php
ob_start();
?>
<?php
if(isset($_REQUEST['ingreso'])){
    require 'metodos/procesos.php';
    $email = $_REQUEST['name'] ?? '';
    $pass = $_REQUEST['password'] ?? '';
    $ingreso = new Ingresar();
    $ingreso ->ingreso($email,$pass);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Style -->

    <link rel="stylesheet" href="customStyleCss/Style.css">
    <link rel="shortcut icon" href="img/login/favicon-34.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">

    <!-- animate css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="Css/animated.css">
    


</head>

<body>

    <section>
        <div class="animate__animated animate__fadeIn">
            <div class="form-container ">
                <img src="img/login/logo-kometa-trans.png" alt="" class="animate__animated animate__fadeInUp">
                <!-- <h1 class="animate__animated animate__fadeInDown">Ingresar</h1> -->

                <form action="login.php" method="POST" class="animate__animated animate__fadeInDown">
                    <div class="control">

                        <label for="name"></label>
                        <input type="email" id="name" name="name" placeholder="Usuario">

                    </div>
                    <div class="control">
                        <label for="psw"><img src="" alt=""></label>
                        <input type="password" id="psw" name="password" placeholder="Contraseña">
                    </div>
                    <span><input type="checkbox"> Recordarme</span>

                    <div class="animate__animated animate__fadeInUp">
                        <div class="control">
                            <input type="submit" class="btn" name="ingreso" value="Ingresar">
                        </div>
                    </div>


                </form>
                <p class="animate__animated animate__fadeInDown"><a href="forgetPassword.php">¿Olvidaste tu contraseña?</a></p>
            </div>
        </div>
    </section>    
    
    
</body>

</html>

<?php
ob_end_flush();
?>