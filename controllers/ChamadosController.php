<?php

require_once "./models/Chamados.php";
require_once "./models/Anexos.php";
require_once "./models/Contatos.php";

class ChamadosController
{
    private $chamado;
    private $contato;
    private $anexo;

    public function __construct()
    {
        $this->chamado = new Chamados();
        $this->anexo = new Anexos();
        $this->contato = new Contatos();
    }

    public function cadastrarChamados()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $descricao = htmlspecialchars($_POST["descricao"], ENT_QUOTES, 'UTF-8');
            $tipo_incidente = htmlspecialchars($_POST["tipo_incidente"], ENT_QUOTES, 'UTF-8');
            $id_usuario = htmlspecialchars($_SESSION["id_usuario"], ENT_QUOTES, 'UTF-8');


            $chmdid = $this->chamado->cadastroChamado($id_usuario, $descricao, $tipo_incidente);

            if ($chmdid) {
                $_SESSION["chamado_id"] = $chmdid;
                echo "Cadastro Realizado!";
            } else {
                echo "Cadastro Falhou!";
            }
        }
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
