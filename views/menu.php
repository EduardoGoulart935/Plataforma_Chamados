<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<body class="d-flex flex-column align-items-center fade-in">

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
                        <h5 class="card-title">Ver Chamados</h5>
                        <p class="card-text">Visualize os chamados cadastrados.</p>
                        <a href="verChamados" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border border-black">
                    <img src="./img/update.jpeg" class="card-img-top" alt="Atualizar Chamados">
                    <div class="card-body text-center">
                        <h5 class="card-title">Atualizar Chamados</h5>
                        <p class="card-text">Atualize informações dos chamados existentes.</p>
                        <a href="#" class="btn btn-primary">Atualizar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

</body>

</html>