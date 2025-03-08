<?php
require_once "./config/database.php";

class Historico{
    private $conn;
    private $table = "historico_chamado";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
   
    public function cadastroHistorico($chmdid, $descricao) {
        $sql = "INSERT INTO {$this->table} (id_chamado, id_usuario, descricao, data_hora
            VALUES (:id_chamado, :id_usuario, :descricao, :data_hora";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":id_chamado", $chmdid);
            $query->bindParam(":id_usuario", $_SESSION["usuario_id"]);
            $query->bindParam(":descricao", $descricao);
            $query->bindParam(":data_hora", NOW());
            $query->execute();
    }
}