<?php
include('db.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM pedidos WHERE usuario_id = '$usuario_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Histórico de Pedidos</h1>
        <div class="text-center mb-3">
            <a href="perfil.php" class="btn btn-secondary">Voltar ao Perfil</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($pedido = $result->fetch_assoc()) { ?>
                    <a href="detalhar_pedido.php?id=<?php echo $pedido['id']; ?>" class="list-group-item list-group-item-action">
                        <h5 class="mb-1">Pedido #<?php echo $pedido['id']; ?></h5>
                        <p class="mb-1">Data: <?php echo $pedido['data']; ?></p>
                        <p class="mb-1">Status: <span class="badge bg-info"><?php echo $pedido['status']; ?></span></p>
                        <p class="mb-1">Endereço: <?php echo $pedido['enderecoEntrega']; ?></p>
                        <p class="mb-1">Método de Pagamento: <?php echo $pedido['metodoPagamento']; ?></p>
                    </a>
                <?php } ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Você ainda não tem pedidos. <a href="produtos.php" class="alert-link">Comece a comprar agora!</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
