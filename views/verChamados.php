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

    <!-- Modal de Atualização -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar Chamado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="chamado-id">
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea id="descricao" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="arquivo" class="form-label">Adicionar Anexo</label>
                        <input type="file" id="arquivo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="atualizarChamado">Atualizar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: './controllers/listarChamados.php',
                method: 'GET',
                data: {
                    action: 'listarChamados'
                },
                dataType: 'json',
                success: function(data) {

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
                                        ${chamado.historicos && chamado.historicos.length > 0 
                                                ? chamado.historicos.map(historico => `${historico.descricao}`).join('')
                                                : '<li>Nenhum contato disponível</li>'}
                                        <p class="card-text">${chamado.descricao}</p>
                                        <button class="btn btn-primary update-btn" data-id="${chamado.id}" data-descricao="${chamado.historicos && chamado.historicos.length > 0 
                                        ? chamado.historicos[chamado.historicos.length - 1].descricao : ''}" data-bs-toggle="modal" data-bs-target="#updateModal"> Atualizar </button>

                                    </div>
                                </div>
                            </div>`;
                    });
                    $('#chamados-container').html(html);
                },
                error: function() {
                    $('#chamados-container').html('<p class="text-danger">Erro ao carregar chamados.</p>');
                }
            });

            $(document).on('click', '.update-btn', function() {
                let id = $(this).data('id');
                let descricao = $(this).data('descricao');
                $('#chamado-id').val(id);
                $('#descricao').val(descricao);
            });

            $('#atualizarChamado').click(function() {
                let id_chamado = $('#chamado-id').val();
                let nova_descricao = $('#descricao').val();
                let arquivo = $('#arquivo')[0].files.length > 0 ? $('#arquivo')[0].files[0] : null;
                let formData = new FormData();
                formData.append('id_chamado', id_chamado);
                formData.append('nova_descricao', nova_descricao);
                formData.append('action', 'atualizarChamado');

                if (arquivo) {
                    formData.append('arquivo', arquivo);
                }

                $.ajax({
                    url: './controllers/atualizarChamados.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            let json = JSON.parse(response);
                            alert(json.mensagem);
                            $('#updateModal').modal('hide');
                            window.location.reload();
                        } catch (e) {
                            console.error("Erro ao processar resposta:", response);
                            alert("Erro ao atualizar chamado.");
                        }
                    },
                    error: function() {
                        alert('Erro ao atualizar chamado.');
                    }
                });
            });
        });
    </script>
</body>

</html>