<?php
session_start();
include("conexão.php");

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../html/cliente-login.html");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Reserva inválida";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Pagamento</title>
<link rel="stylesheet" href="../css/cadastro-senha.css">
<link rel="icon" href="../imgs/icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="form-box">

    <h2>Pagamento da Reserva</h2>

    <form action="../php/processar_pagamento.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $id ?>">

        <select name="pagamento" id="pagamento" required>
            <option value="">Forma de pagamento</option>
            <option value="pix">PIX</option>
            <option value="dinheiro">Dinheiro</option>
            <option value="cartao">Cartão</option>
        </select>

        <div id="pagamentoInfo"></div>

        <div id="comprovanteDiv" style="display:none;">
            <input type="file" name="comprovante">
        </div>

        <button type="submit" class="button-link">Confirmar Pagamento</button>

    </form>

</div>

<script src="../js/pagamento.js"></script>

</body>
</html>