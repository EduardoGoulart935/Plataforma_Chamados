<?php
require_once './vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class PHPMailerHelper {
    public function enviarEmailVerificacao($email, $mensagem) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.seuservidor.com'; // Altere para seu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'eduardotigoulart@gmail.com'; // Seu e-mail SMTP
            $mail->Password = 'eduardo935'; // Sua senha SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuração do e-mail
            $mail->setFrom('eduardogoulart935@gmail', 'Sistema de Chamados');
            $mail->addAddress($email);
            $mail->Subject = 'Código de Verificação';
            $mail->isHTML(true);
            $mail->Body = $mensagem;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

