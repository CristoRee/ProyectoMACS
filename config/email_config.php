<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';



function configurarMailer() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cissalinesz@gmail.com'; 
    $mail->Password = 'dpdr uzot mwzh ubty'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->setFrom('tu_correo@gmail.com', 'BinaryTEC Soporte');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    return $mail;
}

