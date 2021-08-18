<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<body>
    <script src="sweetalert2.all.min.js"></script>
</body>

<?php
class Ingresar
{
    private $conexion;
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }
    function ingreso($email, $pass)
    {
        $sql = "SELECT cedula_usuarios_lip,nombres_usuarios_lip, apellidos_usuarios_lip, tipoUsuario_usuarios_lip FROM kometa_usuarios_lip WHERE correo_usuarios_lip= ? and clave_usuarios_lip= ?; ";
        $stmt = $this->conexion->conexion->prepare($sql);
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            session_start();
            $_SESSION['cedula_usuario'] = $row['cedula_usuarios_lip'];
            $_SESSION['nombres_usuario'] = $row['nombres_usuarios_lip'];
            $_SESSION['apellidos_usuario'] = $row['apellidos_usuarios_lip'];
            $_SESSION['tipoUsuario_usuario'] = $row['tipoUsuario_usuarios_lip'];
            header('location: intereses.php');
            die();
            $stmt->close();
            $this->conexion->cerrar();
        } else {
            echo "<script>
            Swal.fire(
            'Usuario o Contraseña Incorrectos',
            '',
            'error'
            )
            </script>";
        }
    }
}

class Validar
{
    function existente()
    {
        @session_start();
        if (isset($_SESSION['tipoUsuario_usuario']) == Null) {
            header('location:login.php');
        }
    }
    function regenerar()
    {
        session_regenerate_id();
    }
}

class Intereses
{
    private $conexion;
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }
    function guardar($cedula)
    {
        $sql = "INSERT INTO kometa_intereses_lip(cedula_intereses_lip,escritura_intereses_lip, tecnologia_intereses_lip, poesia_intereses_lip,seguridad_intereses_lip,blockchain_intereses_lip,disenoWeb_intereses_lip)VALUES(?,?,?,?,?,?,?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        $escritura = $_REQUEST['escritura'] ?? '';
        $tecnologia = $_REQUEST['tecnologia'] ?? '';
        $poesia = $_REQUEST['poesia'] ?? '';
        $seguridad = $_REQUEST['seguridad'] ?? '';
        $web = $_REQUEST['web'] ?? '';
        $blockchain = $_REQUEST['blockchain'] ?? '';
        $stmt->bind_param("iiiiiii", $cedula, $escritura, $tecnologia, $poesia, $seguridad, $web, $blockchain);
        $stmt->execute();
        header('location: home.php');
        die();
        $stmt->close();
        $this->conexion->cerrar();
    }
}

class Correos
{
    private $conexion;
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }
    function ValidarCorreo($email)
    {
        $sql = "SELECT cedula_usuarios_lip,nombres_usuarios_lip FROM kometa_usuarios_lip WHERE correo_usuarios_lip= ? ";
        $stmt = $this->conexion->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cedula = $row['cedula_usuarios_lip'];
            $nombre = $row['nombres_usuarios_lip'];
            $stmt->close();
            $this->conexion->cerrar();
            $EnviarCorreo = new Correos();
            $EnviarCorreo->EnviarCorreo($email, $cedula, $nombre);
            echo "<script> 
            Swal.fire('Se ha enviado al correo el instructivo para recuperar la contraseña')</script>";
        }
    }

    function EnviarCorreo($email, $cedula, $nombre)
    {
        $codigo = bin2hex(random_bytes(54));
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/SMTP.php';
        $message = '<!DOCTYPE html>
        <html>
        <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <style type="text/css">
            /* FONTS */
            @media screen {
                @font-face {
                    font-family: Lato;
                    font-style: normal;
                    font-weight: 400;
                    src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
                }
                
                @font-face {
                    font-family: "Lato";
                    font-style: normal;
                    font-weight: 700;
                    src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
                }
                
                @font-face {
                    font-family: "Lato";
                    font-style: italic;
                    font-weight: 400;
                    src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
                }
                
                @font-face {
                    font-family: "Lato";
                    font-style: italic;
                    font-weight: 700;
                    src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
                }
            }
            
            /* CLIENT-SPECIFIC STYLES */
            body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
            table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
            img { -ms-interpolation-mode: bicubic; }
        
            /* RESET STYLES */
            img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
            table { border-collapse: collapse !important; }
            body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
            /* iOS BLUE LINKS */
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
            
            /* MOBILE STYLES */
            @media screen and (max-width:600px){
                h1 {
                    font-size: 32px !important;
                    line-height: 32px !important;
                }
            }
        
            /* ANDROID CENTER FIX */
            div[style*="margin: 16px 0;"] { margin: 0 !important; }
        </style>
        </head>
        <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">            
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style:background: grey;>
            <!-- LOGO -->
            <tr>
                <td bgcolor="#FFA73B" align="center">
                    <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                        <tr>
                            <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
                                <a href="http://litmus.com" target="_blank">
                                    <img alt="Logo" src="http://litmuswww.s3.amazonaws.com/community/template-gallery/ceej/logo.png" width="40" height="40" style="display: block; width: 40px; max-width: 40px; min-width: 40px; font-family: Lato, Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            <!-- HERO -->
            <tr>
                <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                    <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                        <tr>
                            <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                <h1 style="font-size: 48px; font-weight: 400; margin: 0;">Recupera Tu Contraseña</h1>
                            </td>
                        </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            <!-- COPY BLOCK -->
            <tr>
                <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                    <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                        <!-- COPY -->
                        <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                            <p style="margin: 0;">Te damos un cordial saludo ' . $nombre . '. Tu seguridad es muy importante para nosotros. Para recuperar tu contraseña solo debes dar click al botón de abajo.</p>
                        </td>
                        </tr>
                        <!-- BULLETPROOF BUTTON -->
                        <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center" style="border-radius: 3px;" bgcolor="#000000"><a href="http://localhost/LIP/cambiarClave.php?codigo=' . $codigo . '" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #000000; display: inline-block;">Recuperar Contraseña</a></td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            </table>
                        </td>
                        </tr>
                        <!-- COPY -->
                        <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                            <p style="margin: 0;">Si no te funciona, da click a la siguiente url o copiala y pegala en el navegador</p>
                        </td>
                        </tr>
                        <!-- COPY -->
                        <tr>
                            <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 20px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                            <p style="margin: 0;"><a href="http://localhost/LIP/cambiarClave.php?codigo=' . $codigo . '" target="_blank" style="color: #FFA73B;">http://localhost/LIP/cambiarClave.php?codigo=' . $codigo . '</a></p>
                            </td>
                        </tr>
                        <!-- COPY -->
                        <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                            <p style="margin: 0;">Si no has sido tu quién ha solicitado el cambio de contraseña, no te preocupes. Puedes ignorar el correo, tu seguridad no se verá afectada.</p>
                        </td>
                        </tr>
                        <!-- COPY -->
                        <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                            <p style="margin: 0;">Saludos,<br>Equipo Kometa</p>
                        </td>
                        </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            <!-- SUPPORT CALLOUT -->
            <tr>
                <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                    <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                        <!-- HEADLINE -->
                        <tr>
                            <td bgcolor="#FFF0D1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;" >
                            <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">¿Tienes Dudas?</h2>
                            <p style="margin: 0;"><a href="http://localhost/LIP/login.php" target="_blank" style="color: #9B4503;">Estamos aquí para resolver tus dudas</a></p>
                            </td>
                        </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
            <!-- FOOTER -->
            <tr>
                <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                    <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" >
                        <!-- NAVIGATION -->
                        <tr>
                        <td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
                            <p style="margin: 0;">
                            <a href="http://localhost/LIP/login.php" target="_blank" style="color: #111111; font-weight: 700;">Inicio</a> -
                            <a href="http://localhost/LIP/login.php" target="_blank" style="color: #111111; font-weight: 700;">Ayuda</a>
                            </p>
                        </td>
                        </tr>
                        <!-- PERMISSION REMINDER -->
                        <tr>
                        <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
                            <p style="margin: 0;">Recibiste este correo porque se solicito cambio de contraseña con tu correo electrónico. Si no fuiste tu, puedes ingresar <a href="http://localhost/LIP/login.php" target="_blank" style="color: #111111; font-weight: 700;">aqui</a>.</p>
                        </td>
                        </tr>
                        <!-- ADDRESS -->
                        <tr>
                        <td bgcolor="#f4f4f4" align="left" style="padding: 0px 30px 30px 30px; color: #666666; font-family: Lato, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;" >
                            <p style="margin: 0;">Equipo Kometa - Plataforma inmersiva de aprendizaje</p>
                        </td>
                        </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </td>
            </tr>
        </table>
            
        </body>
        </html>';
        $sql = "INSERT INTO kometa_cambiosclave_lip(cedula_cambiosClave_lip,codigo_cambiosClave_lip)VALUES(?,?)";
        $stmt = $this->conexion->conexion->prepare($sql);
        $stmt->bind_param("is", $cedula, $codigo);
        $stmt->execute();
        $stmt->close();
        $this->conexion->cerrar();
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'pruebaphpengagement@gmail.com';                     //SMTP username
            $mail->Password   = 'prueba1234';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;
            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('pruebaphpengagement@gmail.com', 'Kometa');
            $mail->addAddress($email, $nombre);     //Add a recipient //Name is optional

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body = $message;

            $mail->AltBody = $message;
            $mail->CharSet = 'UTF-8';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

class CambiarClave
{
    private $conexion;
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }
    function reestablecer($clave)
    {
        $codigo = $_GET['codigo'];
        $sql = "SELECT cedula_cambiosClave_lip FROM kometa_cambiosclave_lip WHERE codigo_cambiosClave_lip= ? ";
        $sql2 = "UPDATE kometa_usuarios_lip SET clave_usuarios_lip = ? WHERE cedula_usuarios_lip = ?";
        $sql3 = "DELETE FROM kometa_cambiosclave_lip WHERE codigo_cambiosClave_lip = ?";
        $stmt = $this->conexion->conexion->prepare($sql);
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cedula = $row['cedula_cambiosClave_lip'];
            $stmt2 = $this->conexion->conexion->prepare($sql2);
            $stmt2->bind_param("si", $clave, $cedula);
            $stmt2->execute();
            $stmt3 = $this->conexion->conexion->prepare($sql3);
            $stmt3->bind_param("s", $codigo);
            $stmt3->execute();
            $stmt->close();
            $stmt2->close();
            $stmt3->close();
            $this->conexion->cerrar();
            header('location: login.php');
            die();
        } else {
            echo "<script>alert('Ya se ha utlizado el código de recuperación');</script>";
        }
    }
}

class Perfil
{
    private $conexion;
    function __construct()
    {
        require_once('conexion.php');
        $this->conexion = new Conexion();
        $this->conexion->conectar();
    }
    function datosPerfil($cedula)
    {
        $sql = "SELECT cedula_usuarios_lip,nombres_usuarios_lip, apellidos_usuarios_lip, correo_usuarios_lip, celular_usuarios_lip FROM kometa_usuarios_lip WHERE cedula_usuarios_lip= ? ";
        $stmt = $this->conexion->conexion->prepare($sql);
        $stmt->bind_param("i", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
?>
            <form action="perfil.php" method="POST" class="formulario">

                <div class="caja2">
                    <label for="">Cedula:</label> <input type="text" name="cedula" id="" value="<?php echo $row['cedula_usuarios_lip']; ?>" readonly>
                    <label for="">Nombre:</label> <input type="text" name="nombre" id="" value="<?php echo $row['nombres_usuarios_lip']; ?>" readonly>
                    <label for="">Apellido:</label> <input type="text" name="apellido" id="" value="<?php echo $row['apellidos_usuarios_lip']; ?>" readonly>
                    <div class="Gperfil">
                        <input type="submit" class="btn" name="Actualizar" value="Actualizar">
                    </div>
                </div>

                <div class="caja2">
                    <label for="">Mail:</label> <input type="mail" name="correo" id="" value="<?php echo $row['correo_usuarios_lip']; ?>">
                    <label for="">Celular:</label> <input type="text" name="celular" id="" value="<?php echo $row['celular_usuarios_lip']; ?>">
                    <a href="actualizarClave.php">
                        <div class="btn-save">
                            <input type="button" class="btn" value="Nueva Contraseña">
                        </div>
                    </a>

                </div>

            </form>
<?php
            $stmt->close();
            $this->conexion->cerrar();
        }
    }

    function Guardar($cedula)
    {
        $sql2 = "UPDATE kometa_usuarios_lip SET correo_usuarios_lip = ?, celular_usuarios_lip = ? WHERE cedula_usuarios_lip = ?;";
        if ($stmt2 = $this->conexion->conexion->prepare($sql2)) {
            $correo = $_REQUEST['correo'] ?? '';
            $celular =  $_REQUEST['celular'] ?? '';
            $stmt2->bind_param("sii", $correo, $celular, $cedula);
            $stmt2->execute();
            $stmt2->close();
            $this->conexion->cerrar();
        }
    }

    function ActualizarClave($cedula)
    {
        $clave = $_REQUEST['clave'] ?? '';
        $nuevaClave =  $_REQUEST['nuevaClave'] ?? '';
        $confirmarNuevaClave =  $_REQUEST['confirmarNuevaClave'] ?? '';
        $sql = "SELECT nombres_usuarios_lip FROM kometa_usuarios_lip WHERE cedula_usuarios_lip= ? AND  clave_usuarios_lip= ? ";
        $stmt = $this->conexion->conexion->prepare($sql);
        $stmt->bind_param("is", $cedula, $clave);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($nuevaClave == $confirmarNuevaClave) {
                $sql2 = "UPDATE kometa_usuarios_lip SET clave_usuarios_lip = ? WHERE cedula_usuarios_lip = ?;";
                if ($stmt2 = $this->conexion->conexion->prepare($sql2)) {
                    $stmt2->bind_param("si", $nuevaClave, $cedula);
                    $stmt2->execute();
                    $stmt2->close();
                    header('location:perfil.php');
                    die();
                }
            } else {
                echo "<script>alert('La nueva contraseña y la confirmación no coinciden');</script>";
            }
            $stmt->close();
            $this->conexion->cerrar();
        } else {
            echo "<script>alert('Error con la contraseña actual ingresada');</script>";
        }
    }
}
?>