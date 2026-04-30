<?php
$servername = "sql110.infinityfree.com";
$database = "if0_41416544_locacao";
$username = "if0_41416544";
$password = "areninha0909";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>