<?php
include './controllers/ApiEstados.php';
include './controllers/ApiCidades.php';

$estados = getEstados();
$cidades = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['estado'])) {
    $estadoSelecionado = $_POST['estado'];
    $cidades = getCidades($estadoSelecionado);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Chamados TI</title>
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
        <div class="card shadow p-4" style="width: 550px;">
            <h2 class="text-center mb-4">Cadastro</h2>
            <br>
            <form action="./controllers/EmailController.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="cadastrar">

                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome Completo" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>

                    <div class="col mb-4">
                        <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="Data de Nascimento" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-4">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>

                    <div class="col">
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="WhatsApp" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="">Selecione o Estado</option>
                            <?php foreach ($estados as $estado): ?>
                                <option value="<?= $estado['sigla'] ?>">
                                    <?= $estado['nome'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <select class="form-control" id="cidade" name="cidade" required>
                            <option value="">Selecione a Cidade</option>
                        </select>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>

                    <div class="col-md-6 mb-5">
                        <input type="password" class="form-control" id="confirmar_senha" placeholder="Confirmar Senha" required>
                        <div class="valid-feedback">Tudo certo!</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </form>

            <div class="text-center mt-3">
                <p>Já possui conta? <a href="login">Faça login</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#estado").change(function() {
                var estadoSelecionado = $(this).val();

                $.post("./controllers/Buscar_cidades.php", {
                    estado: estadoSelecionado
                }, function(data) {
                    $("#cidade").html('<option value="">Selecione a Cidade</option>' + data);
                });
            });
        });

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var formulario = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(formulario, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $('#telefone, #whatsapp').inputmask('(99) 99999-9999');
            $('#data_nascimento').inputmask('99/99/9999');

            $('form').on('submit', function(e) {
                var senha = $('#senha').val();
                var confirmarSenha = $('#confirmar_senha').val();

                if (senha !== confirmarSenha) {
                    alert('As senhas não coincidem.');
                    e.preventDefault();
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.body.classList.add("show");

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
    </script>

</body>

</html>