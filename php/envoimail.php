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
        $mail->Password   = 'g;Re,6}RLKn)qmh';                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = 'UTF-8';
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
        if ($type == "referent")
        $intro = "Bonjour,
<br>
        Nous sommes un dispositif de valorisation de l’engagement des jeunes en Pyrénées-Atlantiques soutenu par l’État, le Conseil Général, le Conseil Régional, les CAF Béarn-Soule et Pays Basque, la MSA, la CPAM.
        <br>
        Nous venons à votre rencontre car un jeune ayant pratiqué une expérience professionnelle à vos côtés s’est inscrit sur notre site et aimerait avoir votre avis sur ses savoirs-êtres et savoir-faire.
        <br>
        En cliquant sur le lien ci-dessous vous serez redirigé vers notre site Jeunes 6.4 où vous retrouverez toutes les informations du jeune en question. Ce système permet aux jeunes qui font un travail sérieux et de qualité d’avoir un CV plus fiable qui se démarque aux yeux des recruteurs.
        <br>
        Merci d’avance pour votre temps.
        <br>
        Cordialement,<br>
        L’équipe Jeunes 6.4" 
        elseif ($type == "consultant") $intro = "Bonjour,
<br>
        Nous sommes un dispositif de valorisation de l’engagement des jeunes en Pyrénées-Atlantiques soutenu par l’État, le Conseil Général, le Conseil Régional, les CAF Béarn-Soule et Pays Basque, la MSA, la CPAM.
        <br>
        Nous venons à votre rencontre car un Jeune s’intéressant à votre entreprise s’est inscrit sur notre site et aimerait avoir votre avis sur son profil professionnel.
        <br>
        En cliquant sur le lien ci-dessous vous serez redirigé vers notre site Jeunes 6.4 où vous retrouverez toutes les informations du jeune, ainsi que les informations sur les personnes qui l’ont référencé, ce qui vous permettra de les contacter afin d’en apprendre plus sur les qualités du jeune.
        Merci d’avance pour votre temps.
<br>
        Cordialement,<br>
        L’équipe Jeunes 6.4";
        else $intro = "Bonjour,<br>

        Nous avons la satisfaction de vous informer que l’une de vos demandes de référencement à été validée. Ce référencement sera donc confirmé dans votre profil et il apparaîtra lorsque vous ferez une demande de consultation.
        <br>
        Au plaisir de vous revoir sur notre site.
        
        
        Cordialement,<br>
        
        L’équipe Jeunes 6.4 "



        $mail->Body    = $intro . '<a href="192.168.1.9/web/'.$type.'.php/?t='.$token.'">192.168.1.9/web/'.$type.'.php/?t='.$token.'</a>';
        $mail->AltBody = 'le site : 192.168.1.9/, token : '.$token;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>