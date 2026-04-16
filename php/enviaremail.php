<?php
session_start();


unset($_SESSION['codigo']);
unset($_SESSION['expira']);

$email = $_SESSION['email'];

if (!isset($_SESSION['email'])) {
    echo "Email não encontrado na sessão ❌";
    exit;
}

// SEMPRE gera novo código
$codigo = rand(100000, 999999);

$_SESSION['codigo'] = $codigo;
$_SESSION['expira'] = time() + 120;

$apiKey = getenv("SENDGRID_API_KEY");

// monta email
$data = [
  "personalizations" => [[
    "to" => [[ "email" => $email ]]
  ]],
  "from" => [
    "email" => "arenashow.startup@gmail.com"
  ],
  "subject" => "Código de Verificação",
  "content" => [[
    "type" => "text/plain",
    "value" => "Seu código de verificação é: $codigo\n\nExpira em 5 minutos."
  ]]
];

// envio
$options = [
  "http" => [
    "header"  => "Authorization: Bearer $apiKey\r\nContent-Type: application/json\r\n",
    "method"  => "POST",
    "content" => json_encode($data)
  ]
];

$context = stream_context_create($options);
$result = file_get_contents("https://api.sendgrid.com/v3/mail/send", false, $context);

// 👉 REDIRECIONA PRA VERIFICAÇÃO
header("Location: ../php/verificacao.php");
exit;

?>