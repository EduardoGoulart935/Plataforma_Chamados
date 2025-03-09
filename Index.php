<?php
ob_start();
session_start();

require_once __DIR__ . '/config/Database.php'; 
require_once __DIR__ . '/controllers/ChamadosController.php';
require_once __DIR__ . '/controllers/UsuariosController.php';
require_once __DIR__ . '/controllers/AnexosController.php';

// Pegando a URL amigável
$url = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$controller = $url[1] ?? 'home'; // Define o primeiro parâmetro da URL como controlador
$action = $url[2] ?? 'index'; // Define o segundo como ação
$param = $url[3] ?? null; // Terceiro parâmetro pode ser um ID

// Definindo rotas
switch ($controller) {
    case 'chamados':
        $chamadosController = new ChamadosController();
        if ($action === 'abrir' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $chamadosController->cadastrarChamados();
        } elseif ($action === 'listar') {
            $chamadosController->listarChamados();
        } else {
            include 'view/erro404.php';
        }
        break;    

    case 'usuarios':
        $usuariosController = new UsuariosController();
        if ($action === 'login') {
            $usuariosController->login();
        } elseif ($action === 'cadastrar') {
            $usuariosController->cadastrarUsuarios();
        } elseif ($action === 'perfil') {
            $usuariosController->perfil();
        } else {
            include 'view/erro404.php';
        }
        break;

    case 'anexos':
        $anexosController = new AnexosController();
        if ($action === 'cadastrarAnexos' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $anexosController->cadastrarAnexos();
        } else {
            include 'view/erro404.php';
        }
        break;

    default:
        include 'view/home.php';
        break;
}

ob_end_flush();
