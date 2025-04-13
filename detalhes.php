<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("Erro: Nenhuma roupa selecionada!");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM roupas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Erro: Roupa não encontrada!");
}

$roupa = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Roupa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #111;
            color: white;
            font-family: 'Roboto', sans-serif;
        }

        .header-custom {
            background: linear-gradient(90deg, rgba(2, 118, 185, 0.32), rgb(36, 35, 35));
            padding: 40px 0;
            text-align: center;
            color: white;
        }

        .header-custom h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 2.5rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
        }

        .btn-custom {
            background-color: rgba(3, 31, 56, 0.53);
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 30px;
            color: white;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: rgb(4, 74, 153);
            transform: scale(1.05);
        }

        .container {
            margin-top: 50px;
        }

        .card-body {
            background-color: rgba(99, 118, 134, 0.31);
            border-radius: 10px;
            padding: 20px;
        }

        .img-fluid {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-size: 2rem;
            color: #d35400;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
        }

        .card-title {
            color: #f39c12;
        }

        .card-text {
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <header class="header-custom">
        <h1>KitNat -  Mostruário Brechó</h1>
        <a href="index.php" class="btn btn-custom mt-3">Voltar ao Catálogo</a>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <?php if (!empty($roupa["imagem"])): ?>
                    <img src="<?= $roupa['imagem'] ?>" alt="Imagem da roupa" class="img-fluid rounded shadow">
                <?php else: ?>
                    <p>Sem imagem disponível</p>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <div class="card-body">
                    <h2 class="text-primary"><?= htmlspecialchars($roupa['nome']); ?></h2>
                    <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($roupa['descricao'])); ?></p>
                    <p><strong>Preço:</strong> R$ <?= number_format($roupa['preco'], 2, ',', '.'); ?></p>

                    <a href="index.php" class="btn btn-custom">Voltar ao Catálogo</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
