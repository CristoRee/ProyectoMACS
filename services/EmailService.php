<?php
// services/EmailService.php

// 1. Incluir las clases de PHPMailer manualmente
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

// 2. Usar los namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; // <-- Importante para la depuración
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $config;

    public function __construct() {
        $this->config = include __DIR__ . '/../config/email_config.php';
    }

    public function enviarNotificacion($destinatario, $asunto, $mensaje, $tipo = 'normal') {
        if (!$this->config['notifications']['enabled']) {
            return true; 
        }

        $mail = new PHPMailer(true);

        try {
            
            $mail->SMTPDebug = SMTP::DEBUG_OFF; 
            $mail->Debugoutput = 'html'; 
           
            $mail->isSMTP();
            $mail->Host       = $this->config['smtp']['host'];
            $mail->SMTPAuth   = $this->config['smtp']['auth'];
            $mail->Username   = $this->config['smtp']['user'];
            $mail->Password   = $this->config['smtp']['pass'];
            $mail->SMTPSecure = $this->config['smtp']['secure'];
            $mail->Port       = $this->config['smtp']['port'];
            
            $mail->setFrom($this->config['smtp']['from_email'], $this->config['smtp']['from_name']);
            
            $mail->addAddress($destinatario);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $asunto;
            $mail->Body    = $this->construirMensaje($mensaje, $tipo);
            $mail->AltBody = strip_tags($mensaje);

            $mail->send();
            return true;

        } catch (Exception $e) {
        
            echo "<h1>Error al enviar el correo</h1>";
            echo "<p>El correo no se pudo enviar. Error de PHPMailer: {$mail->ErrorInfo}</p>";
            echo "<p>Por favor, revisa tu conexión a internet, el Firewall de Windows y asegúrate de que la 'Contraseña de Aplicación' de Gmail sea correcta.</p>";
            die(); 
        }
    }

    private function construirMensaje($cuerpo, $tipo) {
        $color = ($tipo === 'urgente') ? '#dc3545' : '#007bff';
        $titulo = ($tipo === 'urgente') ? '⚠️ Notificación Urgente' : '🔔 Notificación del Sistema';
        
        return "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;'>
            <div style='max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                <h2 style='color: $color; border-bottom: 2px solid $color; padding-bottom: 10px;'>$titulo</h2>
                <div style='margin-top: 20px; padding: 15px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9;'>
                    $cuerpo
                </div>
                <p style='margin-top: 30px; font-size: 0.9em; color: #666;'>
                    Este es un mensaje automático, por favor no responda a este correo.
                </p>
            </div>
        </body>
        </html>
        ";
    }
}