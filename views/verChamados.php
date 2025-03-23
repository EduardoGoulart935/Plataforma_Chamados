<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Chamados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container mt-5">
    <h2>Lista de Chamados</h2>
    <div id="chamados-container" class="row"></div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: './controllers/listarChamados.php',
                method: 'GET',
                data: {
                    action: 'listarChamados'
                }, // Agora estamos passando action corretamente
                dataType: 'json',
                success: function(data) {
                    console.log("Dados recebidos:", data); // Log para verificar o retorno

                    if (!Array.isArray(data)) {
                        console.error("Os dados não são um array:", data);
                        $('#chamados-container').html('<p class="text-danger">Erro ao processar chamados.</p>');
                        return;
                    }

                    let html = '';
                    data.forEach(chamado => {
                        html += `
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Chamado #${chamado.id}</h5>
                                <p class="card-text">${chamado.descricao}</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal${chamado.id}">Detalhes</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal${chamado.id}" tabindex="-1" aria-labelledby="modalLabel${chamado.id}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel${chamado.id}">Detalhes do Chamado #${chamado.id}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Contatos</h6>
                                    <ul>
                                        ${chamado.contatos && chamado.contatos.length > 0 
                                            ? chamado.contatos.map(contato => `<li>${contato.nome} - ${contato.telefone}</li>`).join('')
                                            : '<li>Nenhum contato disponível</li>'}
                                    </ul>
                                    <h6>Anexos</h6>
                                    <ul>
                                        ${chamado.anexos && chamado.anexos.length > 0 
                                            ? chamado.anexos.map(anexo => `<li><a href="data:${anexo.data_upload};base64,${anexo.arquivo_base64}" download="${anexo.tipo_arquivo}">${anexo.nome_arquivo}</a></li>`).join('')
                                            : '<li>Nenhum anexo disponível</li>'}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    });

                    $('#chamados-container').html(html);
                },
                error: function(xhr, status, error) {
                    console.error("Erro na requisição:", status, error);
                    $('#chamados-container').html('<p class="text-danger">Erro ao carregar chamados.</p>');
                }
            });
        });
    </script>
</body>

</html>