<?php

require_once "./models/Historico.php";

class HistoricoController
{
    private $historico;

    public function __construct()
    {
        $this->historico = new Historico();
    }

    public function cadastrarHistorico()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $descricao = htmlspecialchars($_POST["descricao"], ENT_QUOTES, 'UTF-8');
            $chmdid = $_SESSION["id_chamado"];

            $this->historico->cadastroHistorico($chmdid, $descricao);
        }
    }
}
