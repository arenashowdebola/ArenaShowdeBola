<?php
include("../php/conexão.php");

$sql = "SELECT * FROM reserva ORDER BY nome DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Painel Admin</title>
<link rel="stylesheet" href="../css/admin.css">
<link rel="icon" href="../imgs/icon.png"  type="image/x-icon">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet"><meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="container">

    <div class="sidebar">
        <h2>ADMIN</h2>
        <ul>
            <li><a href="../php/admin.php">Todas</a></li>
            <li><a href="../php/listar_reserva.php?status=Pendente">Pendentes</a></li>
            <li><a href="../php/listar_reserva.php?status=Aprovada">Aprovadas</a></li>
            <li><a href="../php/listar_reserva.php?status=Recusada">Recusadas</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="../html/pgini.html" class="btn-voltar">
                ← Voltar ao Início
            </a>
        </div>
    </div>

    <div class="content">
        <h1>Central de Reservas</h1>

        <div class="cards">

        <?php while($row = $result->fetch_assoc()): 
            $classe = strtolower(str_replace(' ', '-', $row['stattus']));
        ?>

            <div class="card card-<?= $classe ?>">
                <div>

                    <p><strong>Nome:</strong> <?= htmlspecialchars($row['nome']) ?></p>
                    <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($row['dataR'])) ?></p>

                    <span class="status-badge badge-<?= $classe ?>">
                        <?= $row['stattus'] ?>
                    </span>
                </div>

                <a class="btn" href="../php/detalhes.php?id=<?= $row['id'] ?>">
                    +Detalhes
                </a>
            </div>

        <?php endwhile; ?>

        </div>
    </div>

</div>

</body>
</html>