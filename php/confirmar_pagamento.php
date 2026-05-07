<?php
include("conexão.php");

$id = $_POST['id'];

$arquivoNome = '';

if (isset($_FILES['comprovante']) && $_FILES['comprovante']['error'] === 0) {

    $arquivoNome = $_FILES['comprovante']['name'];
    $tmp = $_FILES['comprovante']['tmp_name'];

    move_uploaded_file($tmp, "../uploads/" . $arquivoNome);

    $sql = "UPDATE reserva 
            SET stattus = 'PAGO', arquivoCaminho = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $arquivoNome, $id);

} else {

    $sql = "UPDATE reserva 
            SET stattus = 'PAGO' 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
}

$stmt->execute();

header("Location: status.php");
exit;