<?php
@session_start(); // Iniciar sessão
require_once __DIR__ . '/../models/Email.php';
require_once __DIR__ . '/../helpers/PHPMailerHelper.php';
require_once __DIR__ . '/../models/Usuarios.php';

class EmailController {
    private $emailModel;
    private $mailHelper;
    private $usuario;

    public function __construct() {
        $this->mailHelper = new PHPMailerHelper();
        $this->emailModel = new Email();
        $this->usuario = new Usuarios();
    }

    public function enviarVerificacao() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Captura os dados do formulário e armazena na sessão
            $_SESSION['cadastro'] = [
                'nome' => htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8'),
                'data_nascimento' => htmlspecialchars($_POST["data_nascimento"], ENT_QUOTES, 'UTF-8'),
                'email' => htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8'),
                'telefone' => htmlspecialchars($_POST["telefone"], ENT_QUOTES, 'UTF-8'),
                'whatsapp' => htmlspecialchars($_POST["whatsapp"], ENT_QUOTES, 'UTF-8'),
                'senha' => htmlspecialchars($_POST["senha"], ENT_QUOTES, 'UTF-8'),
                'cidade' => htmlspecialchars($_POST["cidade"], ENT_QUOTES, 'UTF-8'),
                'estado' => htmlspecialchars($_POST["estado"], ENT_QUOTES, 'UTF-8')
            ];

            $email = $_SESSION['cadastro']['email'];

            // Gerar um código de 6 dígitos e salvar no banco
            $codigo = mt_rand(100000, 999999);
            $_SESSION['codigo_verificacao'] = $codigo;

            $this->emailModel->salvarCodigoVerificacao( $email, $codigo);

            // Enviar e-mail com código
            $mensagem = "Seu código de verificação é: <strong>$codigo</strong>. Use este código para confirmar seu cadastro.";
            $enviado = $this->mailHelper->enviarEmailVerificacao($email, $mensagem);

            if ($enviado) {
                header("Location: /Plataforma_Chamados/verificao_email");
            } else {
                return json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar e-mail.']);
            }
        }
    }

    public function verificarCodigo() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $codigo = htmlspecialchars($_POST["codigo"], ENT_QUOTES, 'UTF-8');
            $email = $_SESSION['cadastro']['email'] ?? null;

            if (!$email) {
                return json_encode(['success' => false, 'message' => 'Erro: Nenhum e-mail encontrado.']);
            }

            $resultado = $this->emailModel->validarCodigo($email, $codigo);
            if ($resultado) {
                // Recuperar os dados armazenados na sessão
                $dadosCadastro = $_SESSION['cadastro'] ?? [];

                if (!empty($dadosCadastro)) {

                    $this->usuario->cadastro(
                        $dadosCadastro['nome'],
                        $dadosCadastro['data_nascimento'],
                        $dadosCadastro['email'],
                        $dadosCadastro['telefone'],
                        $dadosCadastro['whatsapp'],
                        $dadosCadastro['senha'],
                        $dadosCadastro['cidade'],
                        $dadosCadastro['estado']
                    );

                    unset($_SESSION['cadastro']);
                    unset($_SESSION['codigo_verificacao']);

                    header("Location: /Plataforma_Chamados/login");
                    exit;
                } else {
                    return json_encode(['success' => false, 'message' => 'Erro ao recuperar os dados do cadastro.']);
                }
            } else {
                return json_encode(['success' => false, 'message' => 'Código inválido ou expirado.']);
            }
        }
    }
}

$controller = new EmailController();
if (isset($_POST["action"])) {
    if ($_POST["action"] === "cadastrar") {
        echo $controller->enviarVerificacao();
    }
    if ($_POST["action"] === "verificar") {
        echo $controller->verificarCodigo();
    }
}
