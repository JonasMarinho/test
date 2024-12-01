<?php
include('db.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$pedido_id = $_GET['id']; // Recebe o ID do pedido da URL

// Consultar detalhes do pedido
$sql = "SELECT * FROM pedidos WHERE id = '$pedido_id' AND usuario_id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $pedido = $result->fetch_assoc();

    // Consultar os produtos do pedido
    $sql_produtos = "SELECT p.nome, pp.quantidade, p.preco, pp.quantidade * p.preco as subtotal
                     FROM pedido_produtos pp
                     JOIN produtos p ON pp.produto_id = p.id
                     WHERE pp.pedido_id = '$pedido_id'";
    $produtos_result = $conn->query($sql_produtos);
    
    $total = 0;
    while ($produto = $produtos_result->fetch_assoc()) {
        $total += $produto['subtotal'];
    }
} else {
    echo "Pedido não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Pedido</title>
    <!-- Incluir o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Detalhes do Pedido #<?php echo $pedido['id']; ?></h1>

        <!-- Detalhes do Pedido -->
        <div class="mb-4">
            <h3>Informações do Pedido</h3>
            <p><strong>Data do Pedido:</strong> <?php echo $pedido['data']; ?></p>
            <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
            <p><strong>Endereço de Entrega:</strong> <?php echo $pedido['enderecoEntrega']; ?></p>
            <p><strong>Método de Pagamento:</strong> <?php echo $pedido['metodoPagamento']; ?></p>
        </div>

        <!-- Produtos no Pedido -->
        <div class="mb-4">
            <h3>Produtos</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reset o cursor para a consulta de produtos
                    $produtos_result->data_seek(0);
                    while ($produto = $produtos_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$produto['nome']}</td>
                                <td>{$produto['quantidade']}</td>
                                <td>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>
                                <td>R$ " . number_format($produto['subtotal'], 2, ',', '.') . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Total do Pedido -->
        <div class="text-end">
            <h3>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>
        </div>

        <a href="perfil.php" class="btn btn-secondary mt-4">Voltar ao Perfil</a>
    </div>

    <!-- Incluir o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
