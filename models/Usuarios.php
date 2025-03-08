<?php
require_once "./config/database.php";

class Usuarios {
    private $conn;
    private $table = "usuarios";
    private $tablendereco = "enderecos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
   
    public function cadastro($nome, $data_nascimento, $email, $telefone, $whatsapp, $senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO {$this->table} (nome, data_nascimento, email, telefone, whatsapp, senha)
            VALUES(:nome, :data_nascimento, :email, :telefone, :whatsapp, :senha)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->bindParam(":data_nascimento", $data_nascimento);
        $query->bindParam(":email", $email);
        $query->bindParam(":telefone", $telefone);
        $query->bindParam(":whatsapp", $whatsapp);
        $query->bindParam(":senha", $senha_hash);
        return $query->execute();
    }

    public function cadastroEndereco($cidade, $estado) {
        $sql = "INSERT INTO {$this->tablendereco} (cidade, estado) 
            VALUES (:cidade, :estado)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":cidade", $cidade);
        $query->bindParam(":estado", $estado);
        return $query->execute();
    }

    public function login($email, $senha) {
        $sql = "SELECT email FROM {$this->table} WHERE $email = :email";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":email", $email);
        $query->execute();
        $info = $query->fetch(PDO::FETCH_ASSOC);
        
        if($info && password_verify($senha, $info["senha"])) {
            return $info;
        }
            return false;
    }
}