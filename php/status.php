<?php
session_start();
include("conexão.php");

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ../html/cliente-login.html");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

$sql = "SELECT * FROM reserva WHERE id_cliente = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Minhas Reservas</title>
  <link rel="stylesheet" href="../css/stattus.css">
  <link rel="icon" href="../imgs/icon.png" type="image/x-icon">
  <style>
    .grid-reservas {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }

    </style>
</head>
<body>

<div class="form-box">
  <h2>Minhas Reservas</h2>

  <div class="grid-reservas">

    <?php if ($result->num_rows > 0): ?>

      <?php while ($row = $result->fetch_assoc()): ?>

        <?php
            $statusBanco = strtolower($row["stattus"]); 

            $statusClasse = match($statusBanco) {
                "aprovada" => "aprovada",
                "pendente" => "pendente",
                "recusada" => "recusada",
                default => "pendente"
            };
        ?>

        <div class="card">

          <p><strong>Nome</strong><span><?= $row['nome'] ?></span></p>
          <p><strong>Data</strong><span><?= date('d/m/Y', strtotime($row['dataR'])) ?></span></p>
          <p><strong>Início</strong><span><?= date('H:i', strtotime($row['horaI'])) ?></span></p>
          <p><strong>Término</strong><span><?= date('H:i', strtotime($row['horaT'])) ?></span></p>

          <p>
            <strong>Status</strong>
            <span class="status-badge <?= $statusClasse ?>">
              <?= ucfirst($statusBanco) ?>
            </span>
          </p>

        </div>

      <?php endwhile; ?>

    <?php else: ?>

      <p style="text-align:center; grid-column: 1/-1;">
        Você ainda não possui reservas.
      </p>

    <?php endif; ?>

  </div>
</div>

<button class="menu-float" onclick="window.location.href='../html/area-cliente.html'">←</button>

</body>
</html>