<?php
include('db.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $endereco = $_POST['endereco'];
    $pagamento = $_POST['pagamento'];

    $sql = "INSERT INTO pedidos (usuario_id, status, enderecoEntrega, metodoPagamento) VALUES ('$usuario_id', 'Aguardando Envio', '$endereco', '$pagamento')";
    
    if ($conn->query($sql) === TRUE) {
        $pedido_id = $conn->insert_id;

        $sql = "SELECT * FROM carrinhos WHERE usuario_id = '$usuario_id'";
        $result = $conn->query($sql);
        $carrinho = $result->fetch_assoc();
        $carrinho_id = $carrinho['id'];

        $sql = "SELECT * FROM carrinho_produtos WHERE carrinho_id = '$carrinho_id'";
        $result = $conn->query($sql);

        while ($item = $result->fetch_assoc()) {
            $produto_id = $item['produto_id'];
            $quantidade = $item['quantidade'];
            $sql = "INSERT INTO pedido_produtos (pedido_id, produto_id, quantidade) VALUES ('$pedido_id', '$produto_id', '$quantidade')";
            $conn->query($sql);
        }

        $sql = "DELETE FROM carrinho_produtos WHERE carrinho_id = '$carrinho_id'";
        $conn->query($sql);

        header("Location: historico.php");
        exit;
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Finalizar Compra</h1>
        <form method="POST" action="finalizar_compra.php" class="border p-4 rounded">
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço de Entrega:</label>
                <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Digite seu endereço" required>
            </div>
            <div class="mb-3">
                <label for="pagamento" class="form-label">Método de Pagamento:</label>
                <select id="pagamento" name="pagamento" class="form-select" required>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Boleto">Boleto</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Confirmar Compra</button>
                <a href="carrinho.php" class="btn btn-secondary">Voltar ao Carrinho</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
