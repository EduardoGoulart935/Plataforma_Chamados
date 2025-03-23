<?php
require_once __DIR__ . "/../config/Database.php";

class Contatos
{
    private $conn;

    private $tableContato = "contatos_chamado";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroContatos($id_chamado, $nome, $telefone, $observacao)
    {
        $sql = "INSERT INTO {$this->tableContato} (id_chamado, nome, telefone, observacao)
                VALUES (:id_chamado, :nome, :telefone, :observacao)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $id_chamado);
        $query->bindParam(":nome", $nome);
        $query->bindParam(":telefone", $telefone);
        $query->bindParam(":observacao", $observacao);
        return $query->execute();
    }

    public function selectContatos($id_chamado)
    {
        $sql = "SELECT * FROM {$this->tableContato} WHERE id_chamado = :id_chamado";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
        $query->execute();
        $contato = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($contato) {
            return $contato;
        }
        return false;
    }
}
