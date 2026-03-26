<?php
require 'conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM registros WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header('Location: index.php');
exit;
