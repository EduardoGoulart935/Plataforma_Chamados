<?php
require_once "./config/database.php";

class Historico
{
    private $conn;
    private $tableHistorico = "historico_chamado";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroHistorico($chmdid, $descricao)
    {
        $sql = "INSERT INTO {$this->tableHistorico} (id_chamado, id_usuario, descricao, data_hora)
            VALUES (:id_chamado, :id_usuario, :descricao, NOW())";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $chmdid);
        $query->bindParam(":id_usuario", $_SESSION["usuario_id"]);
        $query->bindParam(":descricao", $descricao);
        $query->execute();
    }

    public function selectHistorico()
    {
        $sql = "SELECT * FROM {$this->tableHistorico}";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $historico = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($historico) {
            return $historico;
        }
        return false;
    }
}
