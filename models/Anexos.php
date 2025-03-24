<?php
require_once __DIR__ . "/../config/Database.php";

class Anexos
{
    private $conn;
    private $tableAnexos = "anexos";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroAnexo($id_chamado, $arquivoNome, $arquivoTipo, $arquivoBase64)
    {
        $sql = "INSERT INTO {$this->tableAnexos} (id_chamado, nome_arquivo, tipo_arquivo, arquivo_base64, data_upload) 
                VALUES (:id_chamado, :nome_arquivo, :tipo_arquivo, :arquivo_base64, NOW())";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $id_chamado);
        $query->bindParam("nome_arquivo", $arquivoNome);
        $query->bindParam(":tipo_arquivo", $arquivoTipo);
        $query->bindParam(":arquivo_base64", $arquivoBase64);
        return $query->execute();
    }
    public function selectAnexos($id_chamado)
    {
        $sql = "SELECT * FROM {$this->tableAnexos} WHERE id_chamado = :id_chamado";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
        $query->execute();
        $anexo = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($anexo) {
            return $anexo;
        }
        return false;
    }
}
