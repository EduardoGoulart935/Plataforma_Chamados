<?php
@session_start();

require_once __DIR__ . "/../models/Chamados.php";
require_once __DIR__ . "/../models/Anexos.php";
require_once __DIR__ . "/../models/Contatos.php";


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
            $id_usuario = $_SESSION["id_usuario"];

            $chmdid = $this->chamado->cadastroChamado($id_usuario, $descricao, $tipo_incidente);

            if ($chmdid) {
                $_SESSION["chamado_id"] = $chmdid;
                echo "Cadastro Realizado!";
            } else {
                echo "Cadastro Falhou!";
            }
        }
    }

    public function cadastrarAnexo()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["arquivo"])) {
            
            $chmdid = $_SESSION["id_chamado"] ?? null;
            if (!$chmdid) {
                echo json_encode(["status" => "erro", "mensagem" => "ID do chamado não encontrado."]);
                return;
            }

            $arquivoNome = $_FILES["arquivo"]["name"];  // Nome original do arquivo
            $arquivoTipo = $_FILES["arquivo"]["type"];  // Tipo MIME do arquivo
            $arquivoTemp = $_FILES["arquivo"]["tmp_name"]; // Caminho temporário

            $arquivoBase64 = base64_encode(file_get_contents($arquivoTemp));

            $this->anexo->cadastroAnexo($chmdid, $arquivoNome, $arquivoTipo, $arquivoBase64);

            echo json_encode(["status" => "sucesso", "mensagem" => "Anexo cadastrado!", "arquivo" => $arquivoNome, "tipo" => $arquivoTipo]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Nenhum arquivo enviado."]);
        }
    }


    public function cadastrarContatos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $telefone = htmlspecialchars($_POST["telefone"], ENT_QUOTES, 'UTF-8');
            $observacao = htmlspecialchars($_POST["observacao"], ENT_QUOTES, 'UTF-8');
            $id_chamado = $_SESSION["id_chamado"];

            $this->contato->cadastroContatos($id_chamado, $nome, $telefone, $observacao);
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

$controller = new ChamadosController();
if (isset($_POST["action"])) {
    if ($_POST["action"] === "cadastrarChamados") {
        $controller->cadastrarChamados();
        $controller->cadastrarAnexo();
        $controller->cadastrarContatos();
    }
}