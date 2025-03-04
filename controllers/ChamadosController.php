<?php

require_once "./models/Chamados.php";

class ChamadosController{
    private $chamado;

    public function __construct(){
        $this->chamado = new Chamados();
    }

    public function cadastrarChamados() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $descricao = $_POST["descricao"];
            $tipo_incidente = $_POST["tipo_incidente"];
            $nome = $_POST["nome"];
            $telefone = $_POST["telefone"];
            $observacao = $_POST["observacao"];
            $nome_arquivo = $_POST["nome_arquivo"];
            $tipo_arquivo = $_POST["tipo_arquivo"];
            $id_usuario = $_SESSION["usuario_id"];


            $chmdid = $this->chamado->cadastroChamado($id_usuario, $descricao, $tipo_incidente);
            $chmd = $this->chamado->cadastroContato($nome, $telefone, $observacao);
            $chmd = $this->chamado->cadastroAnexo($nome_arquivo, $tipo_arquivo);
            
            if($chmdid){
                $_SESSION["chamado_id"] = $chmdid["id"];
                echo "Cadastro Realizado!";
            }else{
                echo "Cadastro Falhou!";
            }
        }  
    } 
}

    $controller = new ChamadosController();
    if(isset( $_POST["action"])){
        if($_POST["action"] === "cadastrarChamados"){$controller->cadastrarChamados();}
    }