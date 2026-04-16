<?php
header('Content-Type: application/json');
include("conexão.php"); 

$data  = $_GET['data'] ?? null;
$horaI = $_GET['horaI'] ?? null;
$horaT = $_GET['horaT'] ?? null;

function normalizarHora($hora) {
    return date("H:i:s", strtotime($hora));
}


if ($data && $horaI && $horaT) {

    $horaI = normalizarHora($horaI);
    $horaT = normalizarHora($horaT);

    $sql = "SELECT 1 FROM reserva 
            WHERE dataR = ?
            AND (horaI < ? AND horaT > ?)
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $data, $horaT, $horaI);
    $stmt->execute();
    $result = $stmt->get_result();

    echo json_encode([
        "ocupado" => $result->num_rows > 0
    ]);
    exit;
}


if ($data) {

    $sql = "SELECT horaI, horaT FROM reserva WHERE dataR = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $data);
    $stmt->execute();
    $result = $stmt->get_result();

    $horarios = [];

    while ($row = $result->fetch_assoc()) {

        $inicio = strtotime(substr($row["horaI"],0,5));
        $fim = strtotime(substr($row["horaT"],0,5));

        for ($t = $inicio; $t < $fim; $t += 3600) {
            $horarios[] = date("H:i", $t);
        }
    }

    echo json_encode(array_unique($horarios));
    exit;
}

echo json_encode([]);