<?php
include 'conexão.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $novoStatus = isset($_POST['status']) ? $_POST['status'] : '';

    if ($id > 0 && in_array($novoStatus, ['Aprovado', 'Recusado'])) {
       
        $sqlBusca = "SELECT * FROM reserva WHERE id = ?";
        $stmtBusca = $conn->prepare($sqlBusca);
        $stmtBusca->bind_param("i", $id);
        $stmtBusca->execute();
        $result = $stmtBusca->get_result();

        if ($result->num_rows === 1) {
            $reserva = $result->fetch_assoc();

            // Insere na tabela reservaconferidos
            $sqlInsere = "INSERT INTO reservaconferidos 
                (id, nome, dataR, horaI, horaT, arquivoNome, stattus)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtInsere = $conn->prepare($sqlInsere);
            if (!$stmtInsere) {
                echo "Erro no prepare (inserção): " . $conn->error;
                exit;
            }
            $stmtInsere->bind_param(
                "issssss",
                $reserva['id'], 
                $reserva['nome'], 
                $reserva['dataR'], 
                $reserva['horaI'], 
                $reserva['horaT'], 
                $reserva['arquivoNome'], 
                $novoStatus
            );
            $stmtInsere->execute();

            // Deleta da tabela reserva
            $sqlDeleta = "DELETE FROM reserva WHERE id = ?";
            $stmtDeleta = $conn->prepare($sqlDeleta);
            $stmtDeleta->bind_param("i", $id);
            $stmtDeleta->execute();

            echo "ok";
            exit;
        } else {
            echo "Reserva não encontrada.";
        }
    } else {
        echo "Dados inválidos.";
    }
} else {
    echo "Método inválido.";
}
