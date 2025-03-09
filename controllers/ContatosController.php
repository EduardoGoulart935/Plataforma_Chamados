<?php

require_once "./models/Contatos.php";

class ContatosController
{
    private $contato;
    public function __construct()
    {
        $this->contato = new Contatos();
    }

    public function cadastrarContatos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $telefone = htmlspecialchars($_POST["telefone"], ENT_QUOTES, 'UTF-8');
            $observacao = htmlspecialchars($_POST["observacao"], ENT_QUOTES, 'UTF-8');
            $chmdid = $_SESSION["id_chamado"];

            $this->contato->cadastroContatos($chmdid, $nome, $telefone, $observacao);
        }
    }
}
