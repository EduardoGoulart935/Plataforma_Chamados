<?php
include 'ApiCidades.php';

if (isset($_POST['estado'])) {
    $estado = $_POST['estado'];
    $cidades = getCidades($estado);
    
    foreach ($cidades as $cidade) {
        echo "<option value='{$cidade['nome']}'>{$cidade['nome']}</option>";
    }
}
