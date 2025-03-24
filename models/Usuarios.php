<?php
@session_start();
require_once __DIR__ . "/../config/Database.php";

class Usuarios
{
    private $conn;
    private $tableUsuarios = "usuarios";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastro($nome, $data_nascimento, $email, $telefone, $whatsapp, $senha, $cidade, $estado)
    {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO {$this->tableUsuarios} (nome, data_nascimento, email, telefone, whatsapp, senha, cidade, estado)
            VALUES(:nome, :data_nascimento, :email, :telefone, :whatsapp, :senha, :cidade, :estado)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->bindParam(":data_nascimento", $data_nascimento);
        $query->bindParam(":email", $email);
        $query->bindParam(":telefone", $telefone);
        $query->bindParam(":whatsapp", $whatsapp);
        $query->bindParam(":senha", $senha_hash);
        $query->bindParam(":cidade", $cidade);
        $query->bindParam(":estado", $estado);
        return $query->execute();
    }

    public function login($email, $senha)
    {
        $sql = "SELECT * FROM {$this->tableUsuarios} WHERE email = :email";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":email", $email);
        $query->execute();
        $info = $query->fetch(PDO::FETCH_ASSOC);

        if ($info && password_verify($senha, $info['senha'])) {
            $_SESSION['id_usuario'] = $info['id'];
            $_SESSION['nome'] = $info['nome'];
            $_SESSION['login'] = true;
            return $info;
        }
        echo"Deu errado!";
        return false;  
    }

    public function selectUsuarios()
    {
        $sql = "SELECT * FROM {$this->tableUsuarios}";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($usuarios) {
            return $usuarios;
        }
        return false;
    }
}
