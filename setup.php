<?php
require_once "db.php";

try {

    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) UNIQUE NOT NULL,
        senha VARCHAR(255) NOT NULL
    )");


    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $senha_hash = password_hash("123456", PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha) VALUES ('admin', ?)");
        $stmt->execute([$senha_hash]);
    }


    $pdo->exec("CREATE TABLE IF NOT EXISTS roupas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        preco DECIMAL(10,2) NOT NULL,
        imagem VARCHAR(255) NOT NULL
    )");


    $pdo->exec("CREATE TABLE IF NOT EXISTS configuracoes (
        chave VARCHAR(50) PRIMARY KEY,
        valor TEXT NOT NULL
    )");


    $stmt = $pdo->prepare("SELECT COUNT(*) FROM configuracoes WHERE chave = 'banner'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO configuracoes (chave, valor) VALUES ('banner', '')");
        $stmt->execute();
    }

    echo "Banco de dados configurado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
