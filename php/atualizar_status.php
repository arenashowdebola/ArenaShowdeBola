<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexão.php");

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$id || !$status) {
    die("Dados inválidos");
}

$sql = "UPDATE reserva SET stattus = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro prepare: " . $conn->error);
}

$stmt->bind_param("si", $status, $id);

if (!$stmt->execute()) {
    die("Erro execute: " . $stmt->error);
}

header("Location: admin.php");
exit;