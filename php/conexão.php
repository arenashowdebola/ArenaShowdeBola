<?php
$servername = "localhost";
$database = "locação";
$username = "root";
$password = "root";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>