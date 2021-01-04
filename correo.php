<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    if(isset($_REQUEST["sendMail"]) && $_REQUEST["sendMail"] != "") {
        $formcontent = '
            <!doctype html>
            <html>
            <head>
            <meta charset="utf-8">
            <title>CORREO</title>
            <style>
            /* cuando es PC */
            @media screen and (min-width: 500px) {
            .contenedor{
                width:700px;
                margin:auto;
            }
            }

            </style>
            </head>

            <body>
            <div class="contenedor">
                <div class="mensaje" style="margin-top:57px;padding:0 49px;">
                    <p>Datos del formulario<br>'."Nombre: $_REQUEST[name] <br> Apellido: $_REQUEST[lastName] <br> Correo electrónico: $_REQUEST[email] <br> Mensaje: $_REQUEST[message]".'</p>
                </div>
            </div>
            </body>
            </html>
        ';
        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;

            $mail->CharSet = 'UTF-8';
            $mail->Username   = 'contacto@electro-tecnica.com'; //correo con el cual se envian los mails
            $mail->Password   = 'Jg12345678'; //conraseña con la cual se envian los mails
            $mail->Port       = 587;
            $mail->setFrom('contacto@electro-tecnica.com', 'TEST');
            $mail->AddAddress("fernanda.gtp87@gmail.com"); //correo al cual se enviara la informacion de este archivo
            $mail->isHTML(true);
            $mail->Subject = "Formulario de contacto";
            $mail->Body    = $formcontent;
            $mail->send();
            echo json_encode(array("msg" => "OK"));
        } catch (Exception $e) {
            echo json_encode(array("msg" => "Error: {$mail->ErrorInfo}"));
        }
    }
    else {
        echo json_encode(array("msg" => "Sin información que procesar"));
    }
    
?>