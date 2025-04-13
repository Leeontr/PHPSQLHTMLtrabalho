<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'brecho';


$conn = new mysqli($host, $user, $password);


if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


$conn->query("CREATE DATABASE IF NOT EXISTS $database");


$conn->select_db($database);


$query = "CREATE TABLE IF NOT EXISTS roupas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255) NOT NULL
)";

$conn->query($query);


if ($conn->connect_error) {
    die("Erro ao selecionar o banco de dados: " . $conn->connect_error);
}


$query = "CREATE TABLE IF NOT EXISTS configuracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(255) NOT NULL UNIQUE,
    valor TEXT NOT NULL
)";
$conn->query($query);


$conn->query("INSERT IGNORE INTO configuracoes (chave, valor) VALUES ('banner', 'caminho_padrao.jpg')");


?>

