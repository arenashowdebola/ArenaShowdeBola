<?php
include 'conexão.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = $_POST["senha"];

    $sql = "INSERT INTO cadastrocliente(nome,email,telefone,senha) VALUES ('$nome', '$email', '$telefone', '$senha')";
    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../html/pgini.html?cadastro=ok");
        exit;
    } else {
        echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
        mysqli_close($conn);
    }
}
?>