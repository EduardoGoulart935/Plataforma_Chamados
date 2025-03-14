<?php
require_once "./config/database.php";

class Anexos
{
    private $conn;
    private $tableAnexos = "anexos";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroAnexo($chmdid, $tipoArquivo, $arquivo)
    {
        $nomeArquivo = $arquivo['name'];
        $tipoArquivo = $arquivo['type'];
        $dadosArquivo = file_get_contents($arquivo['tmp_name']);
        $arquivoBase64 = base64_encode($dadosArquivo);

        $sql = "INSERT INTO {$this->tableAnexos} (id_chamado, nome_arquivo, tipo_arquivo, dados_arquivo, data_upload) 
                VALUES (:id_chamado, :nome_arquivo, :tipo_arquivo, :dados_arquivo, NOW())";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $chmdid);
        $query->bindParam("nome_arquivo", $nomeArquivo);
        $query->bindParam(":tipo_arquivo", $tipoArquivo);
        $query->bindParam(":arquivo_base64", $arquivoBase64);
        return $query->execute();
    }
    public function buscarAnexos($id_chamado)
    {
        $sql = "SELECT id, nome_arquivo, tipo_arquivo, data_upload FROM anexos WHERE id_chamado = :id_chamado";
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
