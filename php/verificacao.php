<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificação</title>
</head>

<body>

  <div class="form-box">
    <h2>Verificação em Duas Etapas</h2>

    <p>
      Enviamos um código para:
      <strong>
        <?php echo $_SESSION['email'] ?? 'seu e-mail'; ?>
      </strong>
    </p>

    <p style="color:red;">
      Obs.: verifique também o spam.
    </p>

    <form action="../php/logincliente.php" method="POST">
      <input type="text" name="codigo" placeholder="Digite o código" required>
      <button type="submit">Verificar</button>
    </form>

  </div>

</body>
</html>