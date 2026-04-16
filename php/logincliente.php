<?php
session_start();
include 'conexão.php';

// 🔐 VALIDAÇÃO DO CÓDIGO
if (isset($_POST['codigo'])) {

    session_start();

    $codigo_digitado = $_POST['codigo'];

    if (!isset($_SESSION['codigo'])) {
        echo "Nenhum código encontrado ❌";
        exit;
    }

    if (time() > $_SESSION['expira']) {
        unset($_SESSION['codigo']);
        echo "Código expirado ❌";
        exit;
    }

    if ($codigo_digitado == $_SESSION['codigo']) {

        // limpa código
        unset($_SESSION['codigo']);
        unset($_SESSION['expira']);

        $_SESSION['verificado'] = true;

        // 👉 AQUI acontece o que você quer
        header("Location: ../html/cliente.html");
        exit;

    } else {
        echo "Código inválido ❌";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, email, senha FROM cadastrocliente WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    if ($senha === $user['senha']) { 
        $_SESSION['id_cliente'] = $user['id']; 
        $_SESSION['email'] = $user['email'];
            header("Location: ../php/enviaremail.php");
            exit();
        } else {
            header("Location: ../html/cliente-login.html?erro=senha");
            exit();
        }
    } else {
        header("Location: ../html/cliente-login.html?erro=usuario");
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>
