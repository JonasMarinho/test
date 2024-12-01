<?php
include('db.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = '$usuario_id'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Meu Perfil</h1>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo $usuario['nome']; ?></h5>
                <p class="card-text"><strong>E-mail:</strong> <?php echo $usuario['email']; ?></p>
                <p class="card-text"><strong>Data de Cadastro:</strong> <?php echo date('d/m/Y', strtotime($usuario['dataCadastro'])); ?></p>
                <a href="notificacoes.php" class="btn btn-primary">Gerenciar Notificações</a>
                <a href="suporte.php" class="btn btn-secondary">Suporte</a>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-outline-primary">Voltar à Loja</a>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
