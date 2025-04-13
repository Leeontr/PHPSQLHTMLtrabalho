<?php
session_start();
require_once "db.php";


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


$queryBanner = "SELECT valor FROM configuracoes WHERE chave = 'banner'";
$stmtBanner = $conn->prepare($queryBanner);
$stmtBanner->execute();
$resultBanner = $stmtBanner->get_result();
$banner = $resultBanner->fetch_assoc()['valor'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: white;
        }
        h1, h2 {
            color: white;
        }
        .card, .table {
            background-color: #495057;
        }
        a {
            color: #007bff;
        }
        a:hover {
            color: #0056b3;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control {
            background-color: #6c757d;
            color: white;
        }
        .form-control:focus {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Painel Administrativo</h1>

        <div class="d-flex justify-content-end mb-4">
            <a href="add_roupa.php" class="btn btn-primary mr-3">Adicionar Roupa</a>
            <a href="logout.php" class="btn btn-danger">Sair</a>
        </div>

        <h2>Configuração do Banner</h2>
        <form action="salvar_banner.php" method="post" class="mb-4">
            <label for="banner" class="form-label">URL da Imagem do Banner:</label>
            <input type="text" id="banner" name="banner" class="form-control" value="<?= htmlspecialchars($banner) ?>" required>
            <button type="submit" class="btn btn-primary mt-2">Salvar</button>
        </form>

        <h2>Roupas Cadastradas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM roupas";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($roupa = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?= $roupa['id'] ?></td>
                        <td><?= $roupa['nome'] ?></td>
                        <td><?= $roupa['descricao'] ?></td>
                        <td>R$ <?= number_format($roupa['preco'], 2, ',', '.') ?></td>
                        <td><img src="<?= $roupa['imagem'] ?>" alt="Imagem da roupa" width="100"></td>
                        <td>
                            <a href="remover_roupa.php?id=<?= $roupa['id'] ?>" class="btn btn-danger btn-sm">Remover</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
