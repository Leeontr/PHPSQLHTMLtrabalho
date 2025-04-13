<?php
require 'db.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    
    if (!isset($conn)) {
        die("Erro: Conexão com o banco de dados não encontrada.");
    }

    
    $stmt = $conn->prepare("DELETE FROM roupas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php"); 
        exit;
    } else {
        echo "Erro ao remover a roupa.";
    }
}
?>
