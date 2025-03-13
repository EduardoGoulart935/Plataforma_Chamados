<?php
function getEstados() {
    $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';
    $response = file_get_contents($url);
    return json_decode($response, true);
}
?>
