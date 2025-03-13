<?php
function getCidades($estado) {
    $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$estado}/municipios";
    $response = file_get_contents($url);
    return json_decode($response, true);
}
?>
