<?php

require_once "./models/Anexos.php";

class AnexosController{
    private $anexo;
    public function __construct(){
        $this->anexo = new Anexos();
    }

    public function cadastrarAnexos(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tipo_arquivo = $_POST["tipo_arquivo"];
            $chmdid = $_SESSION["id_chamado"];
            $arquivo = $_POST["arquivo"];

            $this->anexo->cadastroAnexo($chmdid,$arquivo, $tipo_arquivo);
        }
    }
}