<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Configurado para Mailtrap (desarrollo)
// Crear cuenta gratuita en https://mailtrap.io y obtener credenciales
function configurarMailer() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'tu_username_mailtrap'; // Reemplazar con username de Mailtrap
    $mail->Password = 'tu_password_mailtrap'; // Reemplazar con password de Mailtrap
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;
    $mail->setFrom('noreply@tu-dominio.com', 'BinaryTEC Soporte');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    return $mail;
}