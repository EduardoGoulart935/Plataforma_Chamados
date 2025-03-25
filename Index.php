<?php
ob_start();
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/ChamadosController.php';
require_once __DIR__ . '/controllers/UsuariosController.php';

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Plataforma_Chamados/');

$url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($url[1] !== "Plataforma_Chamados") {
    header("Location: /Plataforma_Chamados/login");
    exit;
}
#$chamadosController = new ChamadosController();if ($action === 'abrir' && $_SERVER['REQUEST_METHOD'] === 'POST') {$chamadosController->
#cadastrarChamados();} elseif ($action === 'listar') { $chamadosController->listarChamados(); } else {include 'view/erro404.php';}

switch ($url[2] ?? 'login') {
    case 'login':
        validaLogin();
        include 'views/login.php';
        break;

    case 'cadastro':
        validaLogin();
        include 'views/cadastro.php';
        break;
    
    case 'verificao_email':
    include 'views/verificacao_email.php';
    break;

    case 'verChamados':
        VerificaSessao();
        include 'views/verChamados.php';
        break;

    case 'cadChamados':
        VerificaSessao();
        include 'views/cadChamados.php';
        break;

    case 'menu':
        VerificaSessao();
        include 'views/menu.php';
        break;

    case 'logout':
        include 'controllers/logout.php';
        break;

    default:
        include 'views/erro404.php';
        exit();
}

function validaLogin()
{
    if (isset($_SESSION['login'])) {
        header("Location: /Plataforma_Chamados/menu");
        exit;
    }
}

function VerificaSessao()
{
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: /Plataforma_Chamados/login");
        exit;
    }
}

ob_end_flush();
