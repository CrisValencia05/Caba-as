<?php
session_start();
include('../db.php');

// Verificar que el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Acceso no autorizado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserva_id'])) {
    $reserva_id = intval($_POST['reserva_id']);
    $cliente_id = $_SESSION['usuario_id'];

    // Asegurarse de que la reserva le pertenece al usuario
    $stmt = $conn->prepare("DELETE FROM reservas WHERE id = ? AND cliente_id = ?");
    $stmt->bind_param("ii", $reserva_id, $cliente_id);

    if ($stmt->execute()) {
        header("Location: reservation.php?deleted=1");
    } else {
        echo "Error al eliminar la reserva.";
    }
} else {
    echo "Datos inválidos.";
}
?>
