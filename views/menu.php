<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        .menu-slide {
            transform: translateX(-100%);
            transition: transform 0.3s ease-out;
        }

        .menu-slide.show {
            transform: translateX(0);
        }
    </style>
</head>

<body class="d-flex flex-column align-items-center fade-in ">

    <div id="loginAlert" class="alert alert-primary fade show" role="alert" style="display: none;">
        Login realizado com sucesso!
    </div>

    <nav class="w-100 p-3 bg-light d-flex justify-content-between">
        <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            ☰ Menu
        </button>

    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <hr>
            <a href="/Plataforma_Chamados/logout" class=" btn btn-danger">Sair</a>
        </div>
    </div>

    <div class="jumbotron jumbotron-fluid p-5 text-center w-75">
        <div class="container border border-secondary rounded p-4">
            <h1 class="display-4">Chamados</h1>
            <p class="lead">Aqui você poderá realizar ações relacionadas aos chamados.</p>
            <hr class="my-4">
            <p>Abaixo estão os cards de funcionalidades disponíveis.</p>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Lista de Chamados</h2>
        <div id="chamados-container" class="row"></div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                                    <h6 class="card-title md-4">${chamado.historicos && chamado.historicos.length > 0 
                                                ? chamado.historicos.map(historico => `${historico.descricao}`).join('')
                                                : ''}</h6>
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

            document.addEventListener("DOMContentLoaded", function() {
                // Efeito de fade-in na página ao carregar
                document.body.classList.add("show");

                // Efeito ao abrir a navbar lateral
                let offcanvasMenu = document.getElementById("sidebarMenu");
                offcanvasMenu.addEventListener("show.bs.offcanvas", function() {
                    offcanvasMenu.classList.add("menu-slide");
                    setTimeout(() => offcanvasMenu.classList.add("show"), 10);
                });

                offcanvasMenu.addEventListener("hide.bs.offcanvas", function() {
                    offcanvasMenu.classList.remove("show");
                    setTimeout(() => offcanvasMenu.classList.remove("menu-slide"), 300);
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                let loginAlert = document.getElementById("loginAlert");
                if (loginAlert) {
                    loginAlert.style.display = "block"; // Exibe o alerta
                    setTimeout(() => {
                        loginAlert.style.opacity = "0";
                        setTimeout(() => loginAlert.style.display = "none", 500);
                    }, 3000);
                }
            });
        </script>
    </div>
    <br><br>
    <div class="container w-75">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card border border-black">
                    <img src="./img/cadas.jpeg" class="card-img-top" alt="Criar Chamados">
                    <div class="card-body text-center">
                        <h5 class="card-title">Criar Chamados</h5>
                        <p class="card-text">Registre novos chamados rapidamente.</p>
                        <a href="cadChamados" class="btn btn-primary">Criar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border border-black">
                    <img src="./img/visual.jpeg" class="card-img-top" alt="Ver Chamados">
                    <div class="card-body text-center">
                        <h5 class="card-title">Histócio Chamados</h5>
                        <p class="card-text">Visualize os chamados cadastrados.</p>
                        <a href="verChamados" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>