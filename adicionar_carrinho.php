<?php
// Conectar ao banco de dados e iniciar a sessão
include('db.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$produto_id = $_POST['produto_id'];
$quantidade = $_POST['quantidade'];

// Verificar se já existe um carrinho para o usuário
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT id FROM carrinhos WHERE usuario_id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $carrinho = $result->fetch_assoc();
    $carrinho_id = $carrinho['id'];
} else {
    $sql = "INSERT INTO carrinhos (usuario_id) VALUES ('$usuario_id')";
    $conn->query($sql);
    $carrinho_id = $conn->insert_id;
}

$sql = "INSERT INTO carrinho_produtos (carrinho_id, produto_id, quantidade) 
        VALUES ('$carrinho_id', '$produto_id', '$quantidade') 
        ON DUPLICATE KEY UPDATE quantidade = quantidade + '$quantidade'";

if ($conn->query($sql) === TRUE) {
    $message = "Produto adicionado ao carrinho com sucesso!";
    $message_class = "alert-success";
} else {
    $message = "Erro ao adicionar produto ao carrinho.";
    $message_class = "alert-danger";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto Adicionado ao Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert <?php echo $message_class; ?> text-center">
            <?php echo $message; ?>
        </div>
        <div class="text-center">
            <a href="carrinho.php" class="btn btn-primary">Ir para o Carrinho</a>
            <a href="produtos.php" class="btn btn-secondary">Continuar Comprando</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
