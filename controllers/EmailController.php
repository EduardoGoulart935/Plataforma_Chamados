<?php

require_once 'models/Email.php';
require_once 'helpers/PHPMailerHelper.php';

class EmailController {
    private $emailModel;
    private $mailHelper;
    public function __construct() {

        $this->mailHelper = new PHPMailerHelper();
        $this->emailModel = new Email();
    }
    
    public function enviarVerificacao() {
        // Gerar um código de 6 dígitos
        $codigo = mt_rand(100000, 999999);

        // Criar o modelo de e-mail e salvar no banco de dados
        
        if (!$this->emailModel->salvarCodigoVerificacao($id_usuario, $email, $codigo)) {
            return ['status' => 'erro', 'mensagem' => 'Erro ao salvar código no banco de dados.'];
        }

        $mensagem = "Seu código de verificação é: <strong>$codigo</strong>. Use este código para confirmar seu cadastro.";
        $enviado = $this->mailHelper->enviarEmailVerificacao($email, $mensagem);

        if ($enviado) {
            return ['status' => 'sucesso', 'mensagem' => 'E-mail enviado com sucesso!'];
        } else {
            return ['status' => 'erro', 'mensagem' => 'Erro ao enviar e-mail.'];
        }
    }

    public function verificarCodigo($email, $codigo) {
        $resultado = $this->emailModel->validarCodigo($email, $codigo);
        if ($resultado) {
            return json_encode(['success' => true, 'message' => 'Código válido!']);
        } else {
            return json_encode(['success' => false, 'message' => 'Código inválido ou expirado.']);
        }
    }
}

$controller = new EmailController();
if( ){

}