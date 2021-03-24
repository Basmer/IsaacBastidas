<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require_once 'OutputMessajes.php';


function sendEmail($name, $mail, $message): bool {
    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();
        $mail->Host       = 'mail.gruposaemi.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'c.sanchez@gruposaemi.com';                     //SMTP username
        $mail->Password   = 'secret';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;
        $mail->setFrom($mail, 'Mailer');
        $mail->isHTML(true);
        $mail->Subject = 'Informacion de Contacto';

        $body = file_get_contents('email_contact.html');
        $body = str_replace(['{{name}}','{{correo}}', '{{$asunto}}', '{{$message}}'], [$name, $mail, 'Inforacion de Contacto', $message], $body);
        $mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        return TRUE;
    }catch (Exception $exception) {
        return FALSE;
    }
}


$formValidator = new \Form\Validator([
    'correo' => ['required', 'trim', 'max_length' => 255, 'email'],
    'nombre' => ['required', 'trim', 'max_length' => 255],
    'asunto' => ['required', 'trim', 'max_length' => 1300],
    'mensaje' => ['required', 'trim', 'max_length' => 1300]
]);

if($formValidator->validate($_POST)) {


    $data = $formValidator->getValues();

    OutputMessajes::sendMesage(SUCCESS, 'Informacion Enviada',
        'Gracias por contactarse conmigo, revisare sus comentarios');

} else {
    OutputMessajes::sendMesage(INVALIDATE_FORM, 'Envio de datos incorrecto',
    'Por favor llene los campos que se requiren en el formulario');
}








