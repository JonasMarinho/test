<?php
include('db.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Consultar os pedidos do usuário
$sql = "SELECT * FROM pedidos WHERE usuario_id = '$usuario_id' ORDER BY data DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <!-- Incluir o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Pedidos</h1>

        <!-- Tabela de Pedidos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($pedido = $result->fetch_assoc()) {
                        // Consultar os produtos do pedido
                        $pedido_id = $pedido['id'];
                        $sql_produtos = "SELECT pp.quantidade, p.preco, pp.quantidade * p.preco as subtotal
                                         FROM pedido_produtos pp
                                         JOIN produtos p ON pp.produto_id = p.id
                                         WHERE pp.pedido_id = '$pedido_id'";
                        $produtos_result = $conn->query($sql_produtos);

                        // Calcular o total do pedido
                        $total = 0;
                        while ($produto = $produtos_result->fetch_assoc()) {
                            $total += $produto['subtotal'];
                        }

                        // Exibir os dados do pedido na tabela
                        echo "<tr>
                                <td>{$pedido['id']}</td>
                                <td>{$pedido['data']}</td>
                                <td>{$pedido['status']}</td>
                                <td>R$ " . number_format($total, 2, ',', '.') . "</td>
                                <td><a href='visualizar_pedido.php?id={$pedido['id']}' class='btn btn-info btn-sm'>Ver Detalhes</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Você não fez nenhum pedido ainda.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="perfil.php" class="btn btn-secondary">Voltar ao Perfil</a>
    </div>

    <!-- Incluir o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
