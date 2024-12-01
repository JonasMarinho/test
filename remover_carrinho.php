<?php
include('db.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$produto_id = $_POST['produto_id'];

// Verificar se o carrinho existe para o usuário
$sql = "SELECT id FROM carrinhos WHERE usuario_id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $carrinho = $result->fetch_assoc();
    $carrinho_id = $carrinho['id'];

    // Remover o produto do carrinho
    $sql = "DELETE FROM carrinho_produtos WHERE carrinho_id = '$carrinho_id' AND produto_id = '$produto_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Feedback de sucesso
        $message = "Produto removido do carrinho com sucesso!";
        $message_class = "alert-success";
    } else {
        // Feedback de erro
        $message = "Erro ao remover o produto do carrinho.";
        $message_class = "alert-danger";
    }
} else {
    // Caso o carrinho não exista
    $message = "Carrinho não encontrado!";
    $message_class = "alert-danger";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover Produto do Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert <?php echo $message_class; ?> text-center">
            <?php echo $message; ?>
        </div>
        <div class="text-center">
            <a href="carrinho.php" class="btn btn-primary">Voltar ao Carrinho</a>
            <a href="produtos.php" class="btn btn-secondary">Continuar Comprando</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
