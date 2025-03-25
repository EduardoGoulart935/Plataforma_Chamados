<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerHelper {
    public function enviarEmailVerificacao($email, $mensagem) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Altere para seu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'coloque o mesmo email aqui'; // Seu e-mail SMTP
            $mail->Password = 'coloque sua senha'; // Sua senha SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuração do e-mail
            $mail->setFrom('coloque o mesmo email aqui', 'Sistema de Chamados');
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

