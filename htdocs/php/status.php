<?php
session_start();
include("conexão.php");

if (!isset($_SESSION['id_cliente'])) {
  header("Location: ../html/cliente-login.html");
  exit();
}

$id_cliente = $_SESSION['id_cliente'];

$sql = "SELECT * FROM reserva WHERE id_cliente = ? ORDER BY dataR DESC, horaI DESC";
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
  <link rel="icon" href="../imgs/icon.png">

  <style>
    .grid-reservas {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }

    .grupo-data {
      grid-column: 1 / -1;
      font-size: 18px;
      font-weight: 700;
      color: #fff;
      margin-top: 10px;
      padding-left: 10px;
      border-left: 4px solid #43A047;
    }

    .card-topo {
      margin-bottom: 12px;
    }

    .horario {
      font-size: 22px;
      font-weight: 700;
      color: #1b5e20;
    }

    .data {
      font-size: 13px;
      color: #2e7d32;
      opacity: 0.8;
    }

    .card-info p {
      margin: 0;
      padding: 10px 12px;
      border-radius: 8px;
      background: rgba(102,187,106,0.12);
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>

<body>

  <div class="form-box">
    <h2>Minhas Reservas</h2>

    <div class="grid-reservas">

      <?php if ($result->num_rows > 0): ?>

        <?php $dataAtual = null; ?>

        <?php while ($row = $result->fetch_assoc()): ?>

          <?php
          $statusBanco = strtolower($row["stattus"]);

          $statusClasse = match ($statusBanco) {
            "aprovada" => "aprovada",
            "pendente" => "pendente",
            "recusada" => "recusada",
            "pago" => "pago",
            default => "pendente"
          };

          $dataFormatada = date('d/m/Y', strtotime($row['dataR']));
          ?>

          <!-- AGRUPAMENTO -->
          <?php if ($dataAtual !== $dataFormatada): ?>
            <div class="grupo-data">
              📅 <?= $dataFormatada ?>
            </div>
            <?php $dataAtual = $dataFormatada; ?>
          <?php endif; ?>

          <!-- CARD -->
          <div class="card">

            <div class="card-topo">
              <div class="horario">
                <?= date('H:i', strtotime($row['horaI'])) ?> - <?= date('H:i', strtotime($row['horaT'])) ?>
              </div>
              <div class="data">
                <?= $dataFormatada ?>
              </div>
            </div>

            <div class="card-info">
              <p>
                <strong>Nome</strong>
                <span><?= $row['nome'] ?></span>
              </p>

              <p>
                <strong>Status</strong>
                <span class="status-badge <?= $statusClasse ?>">
                  <?= ucfirst($statusBanco) ?>
                </span>
              </p>
            </div>

            <?php if ($statusBanco == "aprovada"): ?>
              <a href="pagamento.php?id=<?= $row['id'] ?>" class="btn-pagar">
                💳 Pagar agora
              </a>
            <?php endif; ?>

            <?php if ($statusBanco == "pago"): ?>
              <span class="pago-ok">Pagamento realizado</span>
            <?php endif; ?>

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