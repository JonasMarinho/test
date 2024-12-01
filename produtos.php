<?php
include('db.php');
session_start();

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Produtos</h1>
        <div class="text-center mb-3">
            <a href="perfil.php" class="btn btn-secondary">Voltar ao Perfil</a>
        </div>
        <div class="row">
            <?php while ($produto = $result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                            <p class="card-text"><?php echo $produto['descricao']; ?></p>
                            <p class="text-primary fw-bold">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                            <a href="produto_detalhes.php?id=<?php echo $produto['id']; ?>" class="btn btn-info btn-sm">Ver Detalhes</a>
                        </div>
                        <div class="card-footer">
                            <form method="POST" action="adicionar_carrinho.php" class="d-flex justify-content-between align-items-center">
                                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                <input type="number" name="quantidade" class="form-control me-2" value="1" min="1" style="width: 60px;">
                                <button type="submit" class="btn btn-success btn-sm">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
