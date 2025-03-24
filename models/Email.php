<?php
@session_start();
require_once __DIR__ . "/../config/Database.php";

class Email
{
    private $conn;
    private $tableEmail = "emails_enviados";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function verificarEmail($email) {
        $sql = "SELECT * FROM {$this->tableEmail} WHERE email = :email";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":email", $email);
        $query->execute();
        $verifiEmail = $query->fetch(PDO::FETCH_ASSOC);

        if($verifiEmail){
            return $verifiEmail;
        }
        return false;
    }

    public function salvarCodigoVerificacao($id_usuario, $email, $codigo) {
        $sql = "INSERT INTO {$this->tableEmail} (id_usuario, email_destino, codigo_verificacao) 
                VALUES (:id_usuario, :email_destino, :codigo_verificacao)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_usuario", $id_usuario);
        $query->bindParam(":email_destino", $email);  
        $query->bindParam(":codigo_verificacao", $codigo);
        $query->execute();
    }

    public function validarCodigo($email, $codigo) {
        $sql = "SELECT * FROM {$this->tableEmail} WHERE email_destino = :email AND codigo_verificacao = :codigo";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":email", $email);
        $query->bindParam(":codigo", $codigo);
        $query->execute();

        $email = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($email) {
            return $email;
        }
        return false;
    }   
}