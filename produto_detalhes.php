<?php
include('db.php');
session_start();

$produto_id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE id='$produto_id'";
$result = $conn->query($sql);
$produto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $produto['nome']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="card-title"><?php echo $produto['nome']; ?></h1>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo $produto['descricao']; ?></p>
                <p class="text-primary fw-bold">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            </div>
            <div class="card-footer text-center">
                <form method="POST" action="adicionar_carrinho.php" class="d-inline-flex">
                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                    <input type="number" name="quantidade" class="form-control me-2" value="1" min="1" style="width: 80px;">
                    <button type="submit" class="btn btn-success">Adicionar ao Carrinho</button>
                </form>
                <div class="mt-3">
                    <a href="produtos.php" class="btn btn-secondary">Voltar aos Produtos</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
