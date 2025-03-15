<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Chamados TI</title>
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
<body class="d-flex flex-column min-vh-100 fade-in">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Chamados TI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro">Cadastro</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1>Bem-vindo ao Sistema de Chamados de TI</h1>
            <p class="lead">Facilitamos a abertura e gerenciamento de chamados técnicos</p>
        </div>
    </header>

    <<section class="container d-flex flex-column justify-content-center align-items-center text-center min-vh-50">
        <div class="row">
            <div class="col-md-6">
                <h2 class="fs-1">Como Funciona?</h2>
                <p class="fs-3">Abra um chamado e nossa equipe técnica entrará em contato para resolver seu problema.</p>
            </div>
            <div class="col-md-6">
                <h2 class="fs-1">Precisa de Suporte?</h2>
                <p class="fs-3">Faça login para acompanhar seus chamados ou cadastre-se para criar um novo.</p>
            </div>
        </div>
    </section>
    
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>&copy; 2025 Chamados TI. Todos os direitos reservados.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.body.classList.add("show");

        let offcanvasMenu = document.getElementById("sidebarMenu");
        offcanvasMenu.addEventListener("show.bs.offcanvas", function () {
            offcanvasMenu.classList.add("menu-slide");
            setTimeout(() => offcanvasMenu.classList.add("show"), 10);
        });

        offcanvasMenu.addEventListener("hide.bs.offcanvas", function () {
            offcanvasMenu.classList.remove("show");
            setTimeout(() => offcanvasMenu.classList.remove("menu-slide"), 300);
        });
    });
</script>
</body>
</html>
