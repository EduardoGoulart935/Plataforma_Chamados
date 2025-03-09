<?php
require_once "./config/database.php";

class Contatos
{
    private $conn;

    private $tableContato = "contatos_chamados";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroContatos($chmdid, $nome, $telefone, $observacao)
    {
        $sql = "INSERT INTO {$this->tableContato} (id_chamado, nome, telefone, observacao)
                VALUES (:nome, :telefone, :observacao";
        $query = $this->conn->prepare($sql);
        $query->bindParam("id_chamado", $chmdid);
        $query->bindParam(":nome", $nome);
        $query->bindParam("telefone", $telefone);
        $query->bindParam("observacao", $observacao);
        return $query->execute();
    }

    public function selectContatos()
    {
        $sql = "SELECT * FROM {$this->tableContato}";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $contato = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($contato) {
            return $contato;
        }
        return false;
    }
}
