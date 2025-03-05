<?php
require_once "./controllers/usuariosController.php";

class UsuariosController{
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuarios();
    }

    public function cadastrarUsuarios() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST['nome'];
            $data_nascimento = $_POST['data_nascimento'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $whatsapp = $_POST['whatsapp'];
            $senha = $_POST['senha'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];

            if($this->usuario->cadastrar($nome, $data_nascimento, $email, $telefone, $whatsapp, $senha) && 
               $this->usuario->cadastrarendereco($cidade, $estado)) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro ao Cadastrar Usuário!";
            }
        }
    }

    public function login() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $senha = $_POST["senha"];

            $usuario = $this->usuario->login($email, $senha);
            if($usuario) {
                $_SESSION["usuario_id"] = $usuario["id"];
                echo "Login realizado com sucesso!";
            } else {
                echo "Credenciais inválidas";
            }
        }
    }
}

    $controller = new UsuariosController();
    if(isset($_POST["action"])) {
        if($_POST["action"] === "cadastrar"){ $controller->cadastrarUsuarios();}
        if($_POST["action"] === "login"){ $controller->login();}
    }


