<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Chamado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Chamado criado com sucesso!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Erro ao criar chamado.</div>
    <?php endif; ?>

    <h2>Abrir Chamado</h2>
    <form action="./controllers/ChamadosController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="cadastrarChamados">

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição do Problema</label>
            <textarea class="form-control" id="descricao" name="descricao" required></textarea>
        </div>

        <div class="mb-3">
            <label for="tipo_incidente" class="form-label">Tipo de Incidente</label>
            <select class="form-select" id="tipo_incidente" name="tipo_incidente" required>
                <option value="hardware">Hardware</option>
                <option value="software">Software</option>
                <option value="rede">Rede</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="anexo" class="form-label">Anexos</label>
            <input type="file" class="form-control" id="anexo" name="arquivo" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contatos Telefônicos</label>
            <div id="contatos">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="nome" placeholder="Nome" required>
                    <input type="tel" class="form-control" name="telefone" id="telefone" placeholder="Telefone" required>
                    <input type="text" class="form-control" name="observacao" placeholder="Observação">
                    <button type="button" class="btn btn-danger remove-contato">X</button>
                </div>
            </div>
            <button type="button" id="add-contato" class="btn btn-secondary">Adicionar Contato</button>
        </div>

        <button type="button" class="btn btn-primary" id="btn-abrir-chamado">Abrir Chamado</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#btn-abrir-chamado").click(function() {
                let formData = new FormData($("form")[0]); // Captura os dados do formulário

                $.ajax({
                    url: './controllers/ChamadosController.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        try {
                            let res = JSON.parse(response);
                            if (res.status === "sucesso") {
                                alert("Chamado cadastrado com sucesso!");
                                location.reload(); // Recarregar a página se necessário
                            } else {
                                alert("Erro ao cadastrar chamado: " + res.mensagem);
                            }
                        } catch (error) {
                            console.error("Erro no JSON:", response);
                            alert("Erro inesperado.");
                        }
                    },
                    error: function() {
                        alert("Erro ao enviar o chamado.");
                    }
                });
            });
        });

        document.getElementById("add-contato").addEventListener("click", function() {
            const div = document.createElement("div");
            div.classList.add("input-group", "mb-2");
            div.innerHTML = `
                <input type="text" class="form-control" name="nome" placeholder="Nome" required>
                <input type="tel" class="form-control" name="telefone" id="telefone" placeholder="Telefone" required>
                <input type="text" class="form-control" name="observacao" placeholder="Observação">
                <button type="button" class="btn btn-danger remove-contato">X</button>
            `;
            document.getElementById("contatos").appendChild(div);

            div.querySelector(".remove-contato").addEventListener("click", function() {
                div.remove();
            });
        });

        document.querySelectorAll(".remove-contato").forEach(btn => {
            btn.addEventListener("click", function() {
                this.parentElement.remove();
            });
        });

        $(document).ready(function() {
            $('#telefone').inputmask('(99) 99999-9999');
        });
    
    </script>
</body>

</html>