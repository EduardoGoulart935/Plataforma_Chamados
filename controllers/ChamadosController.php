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
            $descricao = htmlspecialchars($_POST["descricao"], ENT_QUOTES, 'UTF-8');
            $tipo_incidente = htmlspecialchars($_POST["tipo_incidente"], ENT_QUOTES, 'UTF-8');
            $id_usuario = htmlspecialchars($_SESSION["usuario_id"], ENT_QUOTES, 'UTF-8');


            $chmdid = $this->chamado->cadastroChamado($id_usuario, $descricao, $tipo_incidente);

            if ($chmdid) {
                $_SESSION["chamado_id"] = $chmdid;
                echo "Cadastro Realizado!";
            } else {
                echo "Cadastro Falhou!";
            }
        }
    }

    public function listarChamados()
    {
        $chamados = $this->chamado->selectChamados();

        if ($chamados) {
            header('Content-Type: application/json');
            echo json_encode($chamados);
        } else {
            echo json_encode(["message" => "Nenhum chamado encontrado."]);
        }
    }
}
