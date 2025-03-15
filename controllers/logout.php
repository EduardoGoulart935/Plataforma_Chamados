<?php
@session_start();
session_destroy();
header("Location: /Plataforma_Chamados/pagInicial");
exit;
