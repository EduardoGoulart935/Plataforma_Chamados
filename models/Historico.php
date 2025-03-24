<?php
require_once __DIR__ . "/../config/Database.php";

class Historico
{
    private $conn;
    private $tableHistorico = "historico_chamado";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroHistorico($id_chamado, $descricao)
    {
        $sql = "INSERT INTO {$this->tableHistorico} (id_chamado, id_usuario, descricao, data_hora)
            VALUES (:id_chamado, :id_usuario, :descricao, NOW())";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $id_chamado);
        $query->bindParam(":id_usuario", $_SESSION["id_usuario"]);
        $query->bindParam(":descricao", $descricao);
        $query->execute();
    }

    public function selectHistorico($id_chamado)
    {
        $sql = "SELECT * FROM {$this->tableHistorico} WHERE id_chamado = :id_chamado";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
        $query->execute();
        $historico = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($historico) {
            return $historico;
        }
        return false;
    }

    public function updateHistorico($id_chamado, $novaDescricao){
        $sql = "UPDATE {$this->tableHistorico} SET descricao = :descricao WHERE id = :id_chamado AND id_usuario = :id_usuario";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":descricao", $novaDescricao);
        $query->bindParam(":id_chamado", $id_chamado);
        $query->bindParam(":id_usuario", $_SESSION["id_usuario"]);
        $query->execute();
    }
}
