<?php

require_once "./models/Chamados.php";

class ChamadosController
{
    private $chamado;

    public function __construct()
    {
        $this->chamado = new Chamados();
    }

    public function cadastrarChamados()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $descricao = $_POST["descricao"];
            $tipo_incidente = $_POST["tipo_incidente"];
            $id_usuario = $_SESSION["usuario_id"];


            $chmdid = $this->chamado->cadastroChamado($id_usuario, $descricao, $tipo_incidente);

            if ($chmdid) {
                $_SESSION["chamado_id"] = $chmdid;
                echo "Cadastro Realizado!";
            } else {
                echo "Cadastro Falhou!";
            }
        }
    }
}