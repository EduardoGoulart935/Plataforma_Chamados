<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chamados TI</title>
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
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 350px;">
            <h2 class="text-center mb-4">Login</h2>

            <form action="./controllers/UsuariosController.php" method="POST">
            <input type="hidden" name="action" value="login">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <p>Ainda não tem conta? <a href="cadastro">Cadastre-se</a></p>
            </div>
        </div>
    </div>

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