<?php

require_once "./models/Anexos.php";

class AnexosController{
    private $anexo;
    public function __construct(){
        $this->anexo = new Anexos();
    }

    public function cadastrarAnexos(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome_arquivo = $_POST["nome_arquivo"];
            $tipo_arquivo = $_POST["tipo_arquivo"];

            $this->anexo->cadastroAnexo($chmdid,$nome_arquivo, $tipo_arquivo);
        }
    }
}