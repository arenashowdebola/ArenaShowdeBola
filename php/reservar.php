<?php
session_start(); 
include 'conexão.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (!isset($_SESSION['id_cliente'])) {
        echo "Usuário não logado!";
        exit;
    }

    $id_cliente = $_SESSION['id_cliente'];

    $nome  = $_POST["nome"];
    $dataR = $_POST["dataR"];
    $horaI = $_POST["horaI"];
    $horaT = $_POST["horaT"];

    if ($horaI >= $horaT) {
        echo "Horário inválido!";
        exit;
    }

    $sql = "SELECT * FROM reserva 
            WHERE dataR = ? 
            AND (horaI < ? AND horaT > ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $dataR, $horaT, $horaI);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Horário já está ocupado!";
        exit;
    }

    $arquivoNome = '';
    $arquivoCaminho = '';

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {

        $arquivoNome = $_FILES['arquivo']['name'];
        $tmp = $_FILES['arquivo']['tmp_name'];

        $arquivoCaminhoServidor = '../uploads/' . $arquivoNome;

        if (!move_uploaded_file($tmp, $arquivoCaminhoServidor)) {
            echo "Erro ao mover o arquivo.";
            exit;
        }

        $arquivoCaminho = $arquivoNome;
    }

 
    $sql = "INSERT INTO reserva 
    (id_cliente, nome, dataR, horaI, horaT, arquivoNome, arquivoCaminho)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssss",
        $id_cliente,
        $nome,
        $dataR,
        $horaI,
        $horaT,
        $arquivoNome,
        $arquivoCaminho
    );

    if ($stmt->execute()) {
        header("Location: ../html/area-cliente.html");
        exit();
    } else {
        echo "Erro ao inserir dados: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>