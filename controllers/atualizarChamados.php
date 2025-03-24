<?php
@session_start();

require_once __DIR__ . '/../models/Chamados.php';
require_once __DIR__ . '/../models/Usuarios.php';
require_once __DIR__ . '/../models/historico.php';
require_once __DIR__ . "/../models/Anexos.php";

class AtualizarController
{
    private $usuario;
    private $chamado;
    private $historico;
    private $anexos;
    public function __construct()
    {
        $this->usuario = new Usuarios();
        $this->chamado = new Chamados();
        $this->historico = new Historico();
        $this->anexos = new Anexos();
    }

    public function atualizarChamado()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id_chamado = $_POST["id_chamado"];
            $novaDescricao = htmlspecialchars($_POST["nova_descricao"], ENT_QUOTES, 'UTF-8');

            // Atualizar histórico primeiro, independentemente do anexo

            if ( $this->historico->updateHistorico($id_chamado, $novaDescricao )=== false) {
                error_log("Erro ao atualizar histórico para o chamado ID: $id_chamado");
            }

            // Verifica se um arquivo foi enviado
            if (!empty($_FILES["arquivo"]["name"])) {
                $arquivoNome = $_FILES["arquivo"]["name"];
                $arquivoTipo = $_FILES["arquivo"]["type"];
                $arquivoTemp = $_FILES["arquivo"]["tmp_name"];
                $arquivoBase64 = base64_encode(file_get_contents($arquivoTemp));

                if ($this->anexos->cadastroAnexo($id_chamado, $arquivoNome, $arquivoTipo, $arquivoBase64)) {
                    echo " Anexo cadastrado com sucesso!";
                } else {
                    echo " Erro ao cadastrar anexo.";
                }
            }

            echo json_encode(["status" => "sucesso", "mensagem" => "Atualização concluída"]);
            exit;
        }

        echo json_encode(["status" => "erro", "mensagem" => "Requisição inválida."]);
        exit;
    }
}

$controller = new AtualizarController();
if (isset($_POST["action"])) {
    if ($_POST["action"] === "atualizarChamado") {
        echo json_encode($controller->atualizarChamado());
        exit;
    }
}
