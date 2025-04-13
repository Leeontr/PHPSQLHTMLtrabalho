<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    $stmt = $conn->prepare("INSERT INTO roupas (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nome, $descricao, $preco, $imagem);

    if ($stmt->execute()) {
        echo "<script>alert('Roupa adicionada com sucesso!'); window.location.href='admin.php';</script>";
    } else {
        echo "Erro ao adicionar roupa: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Roupa</title>
    <link rel="stylesheet" href="style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Adicionar Nova Roupa</h2>

        <form method="POST" action="add_roupa.php" class="col-md-6 mx-auto">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço:</label>
                <input type="number" step="0.01" id="preco" name="preco" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">URL da Imagem:</label>
                <input type="text" id="imagem" name="imagem" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Adicionar Roupa</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='admin.php'">Voltar</button>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
