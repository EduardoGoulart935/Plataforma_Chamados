<?php
require_once "./config/database.php";

class Contatos{
    private $conn;
    
    private $tableContato = "contatos_chamados";
 
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroContato($chmdid, $nome, $telefone, $observacao){
        $sql = "INSERT INTO {$this->tableContato} (id_chamado, nome, telefone, observacao)
                VALUES (:nome, :telefone, :observacao";
        $query = $this->conn->prepare($sql);
        $query->bindParam("id_chamado", $chmdid);
        $query->bindParam( ":nome", $nome);
        $query->bindParam("telefone", $telefone);
        $query->bindParam("observacao", $observacao);
        return $query->execute();
    }
}