<?php
include('db.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT c.id as carrinho_id, p.id as produto_id, p.nome, p.preco, cp.quantidade 
        FROM carrinhos c 
        JOIN carrinho_produtos cp ON c.id = cp.carrinho_id 
        JOIN produtos p ON cp.produto_id = p.id 
        WHERE c.usuario_id = '$usuario_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Carrinho de Compras</h1>
        <div class="text-center mb-3">
            <a href="perfil.php" class="btn btn-secondary">Voltar ao Perfil</a>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <ul class="list-group mb-3">
                <?php
                $total = 0;
                while ($item = $result->fetch_assoc()) {
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1"><?php echo $item['nome']; ?></h5>
                        <p class="mb-1">Quantidade: <?php echo $item['quantidade']; ?></p>
                        <p class="text-primary fw-bold">Subtotal: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></p>
                    </div>
                    <form method="POST" action="remover_carrinho.php" class="d-inline">
                        <input type="hidden" name="produto_id" value="<?php echo $item['produto_id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                    </form>
                </li>
                <?php } ?>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h4>
                <a href="finalizar_compra.php" class="btn btn-success">Finalizar Compra</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Seu carrinho está vazio. <a href="produtos.php" class="alert-link">Adicione produtos</a>.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
