<?php
include('db.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$produto_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nota = $_POST['nota'];
    $comentario = $_POST['comentario'];

    $sql = "INSERT INTO avaliacoes (usuario_id, produto_id, nota, comentario) VALUES ('$usuario_id', '$produto_id', '$nota', '$comentario')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: produto_detalhes.php?id=$produto_id");
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
    <title>Avaliar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Avaliar Produto</h1>
        <form method="POST" action="avaliar_produto.php?id=<?php echo $produto_id; ?>" class="border p-4 rounded">
            <div class="mb-3">
                <label for="nota" class="form-label">Nota:</label>
                <input type="number" id="nota" name="nota" class="form-control" min="1" max="5" required>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentário:</label>
                <textarea id="comentario" name="comentario" class="form-control" rows="4" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
                <a href="produto_detalhes.php?id=<?php echo $produto_id; ?>" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
