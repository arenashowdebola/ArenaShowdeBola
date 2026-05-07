<?php
session_start();
include("conexão.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $pagamento = $_POST['pagamento'];

    if (!$id || !$pagamento) {
        echo "Dados inválidos";
        exit;
    }

    $comprovanteNome = '';

    if ($pagamento === "pix" && isset($_FILES['comprovante']) && $_FILES['comprovante']['error'] === 0) {

        $comprovanteNome = time() . "_" . $_FILES['comprovante']['name'];
        $tmp = $_FILES['comprovante']['tmp_name'];
        $destino = "../uploads/" . $comprovanteNome;

        if (!move_uploaded_file($tmp, $destino)) {
            echo "Erro ao enviar comprovante";
            exit;
        }
    }

    $sql = "UPDATE reserva 
            SET stattus = 'Pago', pagamento = ?, comprovante = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $pagamento, $comprovanteNome, $id);

    if ($stmt->execute()) {
        header("Location: status.php");
        exit;
    } else {
        echo "Erro ao atualizar pagamento";
    }
}
?>