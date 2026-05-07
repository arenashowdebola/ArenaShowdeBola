<?php
session_start();
include 'conexão.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $senha = $_POST['senha'];

    $sql = "SELECT senha FROM senhabd WHERE senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($senha === $user['senha']) {
            $_SESSION['senha'] = $user['senha'];
            header("Location: ../html/admin-cadastro.html");
            exit();
        } else {
            header("Location: ../html/cadastro-senha.html");
        }
    } else {
        header("Location: ../html/cadastro-senha.html");
    }
    $stmt->close();
    $conn->close();
}
?>