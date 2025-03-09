<?php

require_once "./controllers/ChamadosController.php";
require_once "./controllers/ContatosController.php";
require_once "./controllers/AnexosController.php";
require_once "./controllers/HistoricoController.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $chamados = new ChamadosController();
    $chamados->cadastrarChamados();

    $contato = new ContatosController();
    $contato->cadastrarContatos();

    $anexos = new AnexosController();
    $anexos->cadastrarAnexos();

    $historico = new HistoricoController();
    $historico->cadastrarHistorico();
}
