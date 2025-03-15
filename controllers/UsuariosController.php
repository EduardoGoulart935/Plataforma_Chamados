<?php
require_once __DIR__ . "/../models/Usuarios.php";

class UsuariosController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuarios();
    }

    public function cadastrarUsuarios()
    {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome =     htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $data_nascimento = htmlspecialchars($_POST["data_nascimento"], ENT_QUOTES, 'UTF-8');
            $email =    htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
            $telefone = htmlspecialchars($_POST["telefone"], ENT_QUOTES, 'UTF-8');
            $whatsapp = htmlspecialchars($_POST["whatsapp"], ENT_QUOTES, 'UTF-8');
            $senha =    htmlspecialchars($_POST["senha"], ENT_QUOTES, 'UTF-8');
            $cidade =   htmlspecialchars($_POST["cidade"], ENT_QUOTES, 'UTF-8');
            $estado =   htmlspecialchars($_POST["estado"], ENT_QUOTES, 'UTF-8');;

            if (
                $this->usuario->cadastro($nome, $data_nascimento, $email, $telefone, $whatsapp, $senha, $cidade, $estado)

            ) {
                echo "Cadastro realizado com sucesso!";
                
            } else {
                echo "Erro ao Cadastrar Usuário!";
            }
        }
    }

    public function login()
    {
            
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
            $senha = htmlspecialchars($_POST["senha"], ENT_QUOTES, 'UTF-8');

            $usuario = $this->usuario->login($email, $senha);
            if ($usuario) {    
                header("Location: /Plataforma_Chamados/menu");
                echo "Login bem-sucedido! ID do usuário: " . $_SESSION['id_usuario'];
                exit; 
            } else {
                echo "Credenciais inválidas";
            }
        }
    }
}

$controller = new UsuariosController();
if (isset($_POST["action"])) {
    if ($_POST["action"] === "cadastrar") {
        $controller->cadastrarUsuarios();

    }
    if ($_POST["action"] === "login") {
        $controller->login();
    }
}
