<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Verificação de E-mail</h4>
                </div>
                <div class="card-body">
                    <form action="processa_verificacao.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Digite o código enviado para o seu e-mail</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar Código</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
