<?php
require_once __DIR__ . "/../config/Database.php";

class Contatos
{
    private $conn;

    private $tableContato = "contatos_chamados";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroContatos($id_chamado, $nome, $telefone, $observacao)
    {
        $sql = "INSERT INTO {$this->tableContato} (id_chamado, nome, telefone, observacao)
                VALUES (:id_chamado, :nome, :telefone, :observacao";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $id_chamado);
        $query->bindParam(":nome", $nome);
        $query->bindParam(":telefone", $telefone);
        $query->bindParam(":observacao", $observacao);
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
