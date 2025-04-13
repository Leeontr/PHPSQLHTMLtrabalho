<?php
include 'db.php';

$backup_file = 'backup.sql';

if (!file_exists('db_inicializado.txt')) {
    if (file_exists($backup_file)) {
        $sql = file_get_contents($backup_file);
        if ($conn->multi_query($sql)) {
            echo "Backup importado com sucesso!";
            file_put_contents('db_inicializado.txt', 'true');
        } else {
            echo "Erro ao importar o backup: " . $conn->error;
        }
    } else {
        echo "Arquivo de backup não encontrado!";
    }
}

$conn->query("CREATE DATABASE IF NOT EXISTS brecho");
$conn->select_db("brecho");

$conn->query("CREATE TABLE IF NOT EXISTS roupas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255) NOT NULL
)");

$conn->query("CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(255) NOT NULL UNIQUE,
    valor TEXT NOT NULL
)");

$conn->query("INSERT IGNORE INTO configuracoes (chave, valor) VALUES ('banner', 'banner_padrao.jpg')");

$banner_result = $conn->query("SELECT valor FROM configuracoes WHERE chave = 'banner'");
$banner = $banner_result->fetch_assoc()['valor'] ?? 'banner_padrao.jpg';

$result = $conn->query("SELECT * FROM roupas");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brechó Solidário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
        }

        .login-btn {
            background-color: rgba(3, 31, 56, 0.53);
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 30px;
            color: white;
            transition: 0.3s;
        }

        .login-btn:hover {
            background-color: rgb(4, 74, 153);
            transform: scale(1.05);
        }

        .card {
            background-color:rgba(116, 116, 116, 0.18);
            color: #ffffff;
        }

        .card p.text-success {
            color: #8ef59b !important;
        }
    </style>
</head>
<body>
    <header class="header-custom">
        <h1>KitNat - Mostruário Brechó</h1>
        <a href="login.php" class="btn login-btn mt-3">Login Admin</a>
    </header>

    <div class="container mt-4">
        <div class="mb-4">
            <img id="banner" src="<?= $banner ?>" class="img-fluid w-100 rounded" alt="Banner do Brechó">
        </div>

        <h2 class="text-center mb-4">Catálogo de Roupas Até o Próximo Evento</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <a href="detalhes.php?id=<?= $row['id'] ?>" style="text-decoration: none; color: inherit;">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= $row['imagem'] ?>" class="card-img-top" alt="<?= $row['nome'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['nome'] ?></h5>
                                <p class="card-text"><?= mb_strimwidth($row['descricao'], 0, 100, "...") ?></p>
                                <p class="text-success">R$ <?= number_format($row['preco'], 2, ',', '.') ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
