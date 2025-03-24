<?php
@session_start();

require_once __DIR__ . "/../models/Chamados.php";
require_once __DIR__ . "/../models/Anexos.php";
require_once __DIR__ . "/../models/Contatos.php";
require_once __DIR__ . "/../models/Historico.php";
require_once __DIR__ . '/../models/Usuarios.php';


class ChamadosController
{
    private $chamado;
    private $anexo;
    private $contato;
    private $historico;
    private $usuario;

    public function __construct()
    {
        $this->chamado = new Chamados();
        $this->anexo = new Anexos();
        $this->contato = new Contatos();
        $this->historico = new Historico();
        $this->usuario = new Usuarios();
    }

    public function cadastrarChamados()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $descricao = htmlspecialchars($_POST["descricao"], ENT_QUOTES, 'UTF-8');
            $tipo_incidente = htmlspecialchars($_POST["tipo_incidente"], ENT_QUOTES, 'UTF-8');
            $id_usuario = $_SESSION["id_usuario"];

            $this->chamado->cadastroChamado($id_usuario, $descricao, $tipo_incidente);
            echo json_encode(["status" => "sucesso", "mensagem" => "Chamado cadastrado com sucesso!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Nenhum chamado realizado."]);
        }
    }

    public function cadastrarAnexos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["arquivo"])) {

            $id_chamado = $_SESSION["id_chamado"];
            $arquivoNome = $_FILES["arquivo"]["name"];  // Nome original do arquivo
            $arquivoTipo = $_FILES["arquivo"]["type"];  // Tipo MIME do arquivo
            $arquivoTemp = $_FILES["arquivo"]["tmp_name"]; // Caminho temporário

            $arquivoBase64 = base64_encode(file_get_contents($arquivoTemp));

            if ($this->anexo->cadastroAnexo($id_chamado, $arquivoNome, $arquivoTipo, $arquivoBase64)) {
                return [
                    "status" => "sucesso",
                    "mensagem" => "Anexo cadastrado!",
                    "arquivo" => $arquivoNome,
                    "tipo" => $arquivoTipo
                ];
            } else {
                return ["status" => "erro", "mensagem" => "Erro ao cadastrar anexo."];
            }
        }
        return ["status" => "aviso", "mensagem" => "Nenhum anexo enviado."];
    }


    public function cadastrarContatos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $id_chamado = $_SESSION["id_chamado"];
            $nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
            $telefone = htmlspecialchars($_POST["telefone"], ENT_QUOTES, 'UTF-8');
            $observacao = htmlspecialchars($_POST["observacao"], ENT_QUOTES, 'UTF-8');
            $id_chamado = $_SESSION["id_chamado"];

            if ($this->contato->cadastroContatos($id_chamado, $nome, $telefone, $observacao)) {
                return [
                    "status" => "sucesso",
                    "mensagem" => "Contato cadastrado!",
                    "nome" => $nome,
                    "telefone" => $telefone
                ];
            } else {
                return ["status" => "erro", "mensagem" => "Erro ao cadastrar contato."];
            }
        }
        return ["status" => "aviso", "mensagem" => "Nenhum contato informado."];
    }

    public function cadastrarHistorico() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            date_default_timezone_set('America/Sao_Paulo');

            $id_chamado = $_SESSION["id_chamado"];
            $nome = $_SESSION["nome"];
            $descricao = $nome . ' '. date('d/m/Y H:i:s') . " - Criou o chamado";
            
            if($this->historico->cadastroHistorico($id_chamado, $descricao)){
                return [
                    "status" => "sucesso",
                    "mensagem" => "Historico cadastrado!",
                    "nome" => $descricao,
                ];
            } else {
                return ["status" => "erro", "mensagem" => "Erro ao cadastrar historico."];
            }
        }
        return ["status" => "aviso", "mensagem" => "Nenhum historico informado."];
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
        $controller->cadastrarAnexos();
        $controller->cadastrarContatos();
        $controller->cadastrarHistorico();
    }
}
