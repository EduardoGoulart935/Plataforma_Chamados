<?php

require_once "./models/Contatos.php";

class ContatoController{
    private $contato;
    public function __construct(){
        $this->contato = new Contatos();
    }

    public function cadastrarContatos(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST["nome"];
            $telefone = $_POST["telefone"];
            $observacao = $_POST["observacao"];
            $chmdid = $_SESSION["id_chamado"];
            
            $this->contato->cadastroContato($chmdid,$nome, $telefone, $observacao);
        }
    }
}