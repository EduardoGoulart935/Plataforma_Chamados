<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@session_start();
require_once __DIR__ . '/../models/Chamados.php';
require_once __DIR__ . '/../models/Anexos.php';
require_once __DIR__ . '/../models/Contatos.php';

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

    public function listarChamados()
    {
        $chamados = $this->chamado->selectChamados();
        
        foreach ($chamados as &$chamado) {
            $chamado['contatos'] = $this->contato->selectContatos($chamado['id']);
            $chamado['anexos'] = $this->anexo->selectAnexos($chamado['id']);
        }

        header('Content-Type: application/json');
        echo json_encode($chamados);
    }
}

$controller = new ChamadosController();
if (isset($_GET['action']) && $_GET['action'] === 'listarChamados') {
    $controller->listarChamados();
}
