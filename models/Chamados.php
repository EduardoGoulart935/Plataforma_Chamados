<?php

require_once "../config/Database.php";

class Chamados{
    private $conn;
    private $tableChamados = "chamados";
    private $tableContato = "contatos_chamados";
    private $tableAnexos = "anexos";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function cadastroChamado($descricao, $tipo_incidente, $id_usuario) {
        $sql = "INSERT INTO {$this->tableChamados} (id_usuario, descricao, tipo_incidente, status)
                VALUES (:id_usuario, :descricao, :tipo_incidente, :status";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":descricao", $descricao);
        $query->bindParam(":tipo_incidente", $tipo_incidente);
        $query->bindParam(":id_usuario", $id_usuario);
        return $query->execute();
    }

    public function cadastroContato($nome, $telefone, $observacao){
        $sql = "INSERT INTO {$this->tableContato} (nome, telefone, observacao)
                VALUES (:nome, :telefone, :observacao";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->bindParam("telefone", $telefone);
        $query->bindParam("observacao", $observacao);
        return $query->execute();
    }

    public function cadastroAnexo($id_chamado, $arquivo) {
        $nomeArquivo = $arquivo['name'];
        $tipoArquivo = $arquivo['type'];
        $dadosArquivo = file_get_contents($arquivo['tmp_name']);
        $arquivoBase64 = base64_encode($dadosArquivo);

        $sql = "INSERT INTO {$this->tableAnexos} (id_chamado, nome_arquivo, tipo_arquivo, dados_arquivo, data_upload) 
                VALUES (:id_chamado, :nome_arquivo, :tipo_arquivo, :dados_arquivo, NOW())";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id_chamado", $id_chamado);
        $query->bindParam("nome_arquivo", $nomeArquivo);
        $query->bindParam(":tipo_arquivo", $tipoArquivo);
        $query->bindParam(":arquivo_base64", $arquivoBase64);
        return $query->execute();
    }

    public function buscarAnexos($id_chamado) {
        $sql = "SELECT id, nome_arquivo, tipo_arquivo, data_upload FROM anexos WHERE id_chamado = :id_chamado";
        $query = $this->conn->prepare($sql);
        $query->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function exibirAnexo($id) { #ARRUMAR O $id 
        $sql = "SELECT nome_arquivo, tipo_arquivo, dados_arquivo FROM anexos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $anexo = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($anexo) {
            header("Content-Type: " . $anexo['tipo_arquivo']);
            echo $anexo['dados_arquivo'];
            exit;
        } else {
            echo "Arquivo não encontrado.";
        }
    }
}