<?php
include("conexão.php");

$status = $_GET['status'] ?? null;

if ($status) {
    $sql = "SELECT * FROM reserva WHERE stattus = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM reserva ORDER BY id DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Reservas</title>
<link rel="stylesheet" href="../css/listar_reserva.css">
<link rel="icon" href="../imgs/icon.png">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="container">

    <div class="sidebar">
        <h2>ADMIN</h2>
        <ul>
            <li><a href="../php/admin.php">Todas</a></li>
            <li><a href="listar_reserva.php?status=Pendente">Pendentes</a></li>
            <li><a href="listar_reserva.php?status=Aprovada">Aprovadas</a></li>
            <li><a href="listar_reserva.php?status=Recusada">Recusadas</a></li>
            <li><a href="listar_reserva.php?status=Pago">Pagas</a></li>
        </ul>

        <div class="sidebar-footer">
            <a href="../html/pgini.html" class="btn-voltar">
                ← Voltar ao Início
            </a>
        </div>
    </div>

    <div class="content">
        <h1><?= htmlspecialchars($status) ?></h1>

        <div class="cards">

        <?php if ($result->num_rows > 0): ?>

            <?php while($row = $result->fetch_assoc()): 
                $classe = strtolower($row['stattus']);
            ?>

                <div class="card card-<?= $classe ?>">
                    <div>
                        <p><strong>Nome:</strong> <?= htmlspecialchars($row['nome']) ?></p>
                        <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($row['dataR'])) ?></p>

                        <span class="status-badge badge-<?= $classe ?>">
                            <?= $row['stattus'] ?>
                        </span>
                    </div>

                    <a class="btn" href="detalhes.php?id=<?= $row['id'] ?>">
                        +Detalhes
                    </a>
                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p style="text-align:center; grid-column: 1/-1;">
                Nenhuma reserva encontrada.
            </p>

        <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>