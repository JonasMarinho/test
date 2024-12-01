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
    $isInscrito = isset($_POST['isInscrito']) ? 1 : 0;

    $sql = "UPDATE usuarios SET isInscritoNotificacoes = '$isInscrito' WHERE id = '$usuario_id'";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Preferências atualizadas com sucesso!";
        $message_class = "alert-success";
    } else {
        $message = "Erro ao atualizar preferências.";
        $message_class = "alert-danger";
    }
}

$sql = "SELECT isInscritoNotificacoes FROM usuarios WHERE id = '$usuario_id'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notificações</title>
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

        <h1 class="text-center">Gerenciar Notificações</h1>
        <a href="perfil.php" class="btn btn-secondary mb-3">Voltar ao Perfil</a>

        <!-- Formulário para gerenciar notificações -->
        <form method="POST" action="notificacoes.php" class="text-center">
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="isInscrito" name="isInscrito" <?php if ($usuario['isInscritoNotificacoes']) echo 'checked'; ?>>
                <label class="form-check-label" for="isInscrito">Inscrever-se para notificações</label>
            </div>
            <br>
            <input type="submit" class="btn btn-primary" value="Salvar Preferências">
        </form>
    </div>

    <!-- Incluir o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
