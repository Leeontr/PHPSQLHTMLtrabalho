<?php
session_start();
require_once "db.php";


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['banner'])) {
    $banner = $_POST['banner'];

    
    $query = "UPDATE configuracoes SET valor = ? WHERE chave = 'banner'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $banner);
    $stmt->execute();

    
    header("Location: index.php");
    exit();
} else {
    
    header("Location: admin.php");
    exit();
}
