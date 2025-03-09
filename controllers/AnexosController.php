<?php

require_once "./models/Anexos.php";

class AnexosController
{
    private $anexo;
    public function __construct()
    {
        $this->anexo = new Anexos();
    }

    public function cadastrarAnexos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tipo_arquivo =  htmlspecialchars($_POST["tipo_arquivo"], ENT_QUOTES, 'UTF-8');
            $chmdid = $_SESSION["id_chamado"];
            $arquivo = htmlspecialchars($_POST["arquivo"], ENT_QUOTES, 'UTF-8');

            $this->anexo->cadastroAnexo($chmdid, $arquivo, $tipo_arquivo);
        }
    }
}
