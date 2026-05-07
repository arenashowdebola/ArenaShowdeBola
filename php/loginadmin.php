<?php
session_start();
include 'conexão.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT email, senha FROM cadastroadmin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($senha === $user['senha']) {
            $_SESSION['email'] = $user['email'];
            header("Location: ../php/admin.php");
            exit();
        } else {
            header("Location: ../html/admin-login.html?erro=senha");
            exit();
        }
    } else {
        header("Location: ../html/admin-login.html?erro=email");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
