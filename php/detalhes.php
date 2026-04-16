<?php
include("conexão.php");

$id = $_GET['id'];

$sql = "SELECT * FROM reserva WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Detalhes da Reserva</title>
<link rel="stylesheet" href="../css/detalhes.css">
<link rel="icon" href="../imgs/icon.png"  type="image/x-icon">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="detalhe-container">

    <div class="content">
        <h1>Detalhes da Reserva</h1>

        <div class="detalhe-container">

            <div class="detalhe-card">
                <p><strong>Nome:</strong> <?= htmlspecialchars($row['nome']) ?></p>
                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($row['dataR'])) ?></p>
                <p><strong>Horário Início:</strong> <?= date('H:i', strtotime($row['horaI'])) ?></p>
                <p><strong>Horário Término:</strong> <?= date('H:i', strtotime($row['horaT'])) ?></p>

            <?php if (!empty($row['arquivoCaminho'])): ?>
                <img src="../uploads/<?php echo $row['arquivoCaminho']; ?>" style="max-width:100%;">
            <?php else: ?>
                <p>Sem comprovante enviado.</p>
            <?php endif; ?>
            </div>

            <div class="menu-status">
                <form action="atualizar_status.php" method="POST">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                    <h3>Status da Reserva</h3>

                    <label>
                        <input type="radio" name="status" value="Pendente" <?= $row['stattus'] == 'Pendente' ? 'checked' : '' ?>>
                        Pendente
                    </label>

                    <label>
                        <input type="radio" name="status" value="Aprovada" <?= $row['stattus'] == 'Aprovada' ? 'checked' : '' ?>>
                        Aceitar
                    </label>

                    <label>
                        <input type="radio" name="status" value="Recusada" <?= $row['stattus'] == 'Recusada' ? 'checked' : '' ?>>
                        Recusar
                    </label>

                    <button type="submit">Atualizar Status</button>
                </form>
            </div>

        </div>
    </div>

</div>

</body>
</html>