<?php
include('db.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensagem = $_POST['mensagem'];

    $sql = "INSERT INTO suporte (usuario_id, mensagem, status) VALUES ('$usuario_id', '$mensagem', 'pendente')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Mensagem enviada com sucesso!";
        $message_class = "alert-success";
    } else {
        $message = "Erro ao enviar mensagem.";
        $message_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte</title>
    <!-- Incluir o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Exibir feedback de sucesso ou erro -->
        <?php if (isset($message)): ?>
            <div class="alert <?php echo $message_class; ?> text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center">Suporte</h1>
        <a href="perfil.php" class="btn btn-secondary mb-3">Voltar ao Perfil</a>

        <!-- Formulário para enviar mensagem de suporte -->
        <form method="POST" action="suporte.php">
            <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem:</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
        </form>
    </div>

    <!-- Incluir o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
