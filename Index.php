<?php
ob_start();
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/ChamadosController.php';
require_once __DIR__ . '/controllers/UsuariosController.php';
require_once __DIR__ . '/controllers/AnexosController.php';

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Plataforma_Chamados/');

$url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$controller = $url[1] ?? 'home'; // Define o primeiro parâmetro da URL como controlador
$action = $url[2] ?? 'index'; // Define o segundo como ação
$param = $url[3] ?? null; // Terceiro parâmetro pode ser um ID

if ($url[1] == "/Plataforma_Chamados") {
    header("Location: /Plataforma_Chamados/pagInicial");
    exit;
}
#$chamadosController = new ChamadosController();if ($action === 'abrir' && $_SERVER['REQUEST_METHOD'] === 'POST') {$chamadosController->
#cadastrarChamados();} elseif ($action === 'listar') { $chamadosController->listarChamados(); } else {include 'view/erro404.php';}

switch ($url[2] ?? 'pagInicial') {
    case 'pagInicial':
        include 'views/pagInicial.php';
        break;

    case 'login':
        include 'views/login.php';
        break;

    case 'cadastro':
        include 'views/cadastro.php';
        break;

    case 'menu':
        include 'views/menu.php';
        break;

    case 'logout':
        include 'controllers/logout.php';
        break;

    default:
        include 'views/erro404.php';
        exit();
}

ob_end_flush();
