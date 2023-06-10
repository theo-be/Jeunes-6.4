<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';





function envoyermail ($vers, $type, $objet, $token) {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.laposte.net';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'service-jeunes-6.4@laposte.net';       //SMTP username
        $mail->Password   = 'g;Re,6}RLKn)qmh';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        // $mail->setLanguage('fr', '/optional/path/to/language/directory/');

        //Recipients
        $mail->setFrom('service-jeunes-6.4@laposte.net', 'Service Jeunes 6.4');
        $mail->addAddress($vers);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $objet;
        $intro = (($type == "referent") ? "<meta charset=\"UTF-8\">Bonjour, une demande de référencement a été faite, cliquez ici : " : "<meta charset=\"UTF-8\">Bonjour, une demande de consultation a été faite, cliquez ici : ");
        $mail->Body    = $intro . '<a href="192.168.1.9/web/'.$type.'.php/?t='.$token.'">192.168.1.9/web/'.$type.'.php/?t='.$token.'</a>';
        $mail->AltBody = 'normalement c\'est bon <a href="192.168.1.9/">le site</a>';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>