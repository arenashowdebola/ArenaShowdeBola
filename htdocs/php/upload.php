<?php
include 'conexão.php';

if (isset($_FILES['arquivo'])) {
    $nome = $_FILES['arquivo'] ['name'];
    $tmp = $_FILES['arquivo'] ['tmp_name'];
    $destino = '../uploads/' .$nome;

    if (move_uploaded_file($tmp, $destino)){
        $stmt = $conn->prepare("INSERT INTO upload(nome, caminho) VALUES (?,?)");
        $stmt->bind_param("ss", $nome, $destino);
        $stmt->execute();
        echo "<p id='form-box'>Reserva concluída com sucesso<p>";
        echo "<a href='../html/pgdet.html' id='volt'>Voltar a página incial</a>";
    } else {
        echo "<p id='form-box'>Erro no upload do comprovante!<p>";
        echo "<a href='../html/ConfReserva.html' id='volt'>Tentar novamente</a>";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="../imgs/icon.png" type="image/x-icon">
    <style>
        #form-box {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 350px;
    background: linear-gradient(135deg, green, lightgreen);
    height: 20px;
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    text-align: center;
    }
     #volt{
        background: linear-gradient(135deg,rgb(136, 255, 100), lightgreen);
        border-radius: 30px;
        padding: 5px;
        text-decoration: none;
        color: black;
     }
    </style>
</head>
<body>
    
</body>
</html>