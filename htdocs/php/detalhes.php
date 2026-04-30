<?php
include("conexão.php");

$id = $_GET['id'] ?? 0;

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="detalhe-container">

<h1>Detalhes da Reserva</h1>

<div class="detalhe-card">

<p><strong>Nome:</strong> <?= htmlspecialchars($row['nome']) ?></p>
<p><strong>Data:</strong> <?= date('d/m/Y', strtotime($row['dataR'])) ?></p>
<p><strong>Início:</strong> <?= date('H:i', strtotime($row['horaI'])) ?></p>
<p><strong>Fim:</strong> <?= date('H:i', strtotime($row['horaT'])) ?></p>

<p><strong>Status:</strong> <?= htmlspecialchars($row['stattus']) ?></p>
<p><strong>Pagamento:</strong> <?= htmlspecialchars($row['pagamento'] ?? 'Não definido') ?></p>

<?php if (!empty($row['comprovante'])): ?>
    <p><strong>Comprovante:</strong></p>
    <img src="../uploads/<?= htmlspecialchars($row['comprovante']) ?>" style="max-width:300px;">
<?php endif; ?>

</div>

<div class="menu-status">
<form action="atualizar_status.php" method="POST">

<input type="hidden" name="id" value="<?= $row['id'] ?>">

<h3>Status</h3>

<label>
<input type="radio" name="status" value="Pendente" <?= $row['stattus']=='Pendente'?'checked':'' ?>>
Pendente
</label>

<label>
<input type="radio" name="status" value="Aprovada" <?= $row['stattus']=='Aprovada'?'checked':'' ?>>
Aprovar
</label>

<label>
<input type="radio" name="status" value="Recusada" <?= $row['stattus']=='Recusada'?'checked':'' ?>>
Recusar
</label>

<button type="submit">Atualizar</button>

</form>
</div>

<div style="margin-top:20px;">
    <a href="admin.php" class="btn-voltar">← Voltar</a>
</div>

</div>

</body>
</html>