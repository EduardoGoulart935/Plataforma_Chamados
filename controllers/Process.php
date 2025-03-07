<?php

require_once "./controllers/ChamadosController.php";
require_once "./controllers/ContatosController.php";
require_once "./controllers/AnexosController.php";

 if($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $contato = new ContatoController();
    $contato->cadastrarContatos();

    $chamados = new ChamadosController();
    $chamados->cadastrarChamados();

    $anexos = new AnexosController();
    $anexos->cadastrarAnexos();


}