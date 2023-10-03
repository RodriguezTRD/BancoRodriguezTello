<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php'; 

$mail = new PHPMailer();

// Configura el servidor SMTP de Gmail
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'rodrigueztellorodrigodaniel@gmail.com';
$mail->Password = 'Paula270405'; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Configura el correo
$mail->setFrom('rodrigueztellorodrigodaniel@gmail.com', 'Rodrigo Daniel Rodriguez Tello');  
$mail->addAddress('rodrigueztellorodrigodaniel@example.com'); 
$mail->Subject = 'Asunto del correo';
$mail->Body = 'Contenido del correo';

// Realiza el envio
if ($mail->send()) {
    echo 'Correo enviado correctamente';
} else {
    echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
}
?>
