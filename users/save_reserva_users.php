<?php
session_start();
include('../db.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "Usuario no autenticado.";
    exit;
}

$cliente_id = $_SESSION['usuario_id'];

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    // Obtener el email desde la base de datos
    $stmt = $conn->prepare("SELECT email FROM clientes WHERE cliente_id = ?");
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $email = $result->fetch_assoc()['email'];
    } else {
        echo "No se pudo obtener el email del usuario.";
        exit;
    }
}


$type = $_POST['type'] ?? null;
$fecha_solicitud = date('Y-m-d');
$fecha_llegada = $_POST['fecha_llegada'] ?? null;
$fecha_salida = $_POST['fecha_salida'] ?? null;
$servicios_extra = $_POST['servicios_extra'] ?? '';


// Validación básica
if (!$type) {
    echo "No se recibió el tipo de cabaña.";
    exit;
}

// Buscar una cabaña disponible del tipo seleccionado
$query = "SELECT id FROM glamping WHERE type = ? AND disponible = 1 LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cabana = $result->fetch_assoc();
    $cabana_id = $cabana['id'];

    // Insertar la reserva
    $insert = "INSERT INTO reservas (cliente_id, email, cabana_id, fecha_solicitud, fecha_llegada, fecha_salida, servicios_extra) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("isissss", $cliente_id, $email, $cabana_id, $fecha_solicitud, $fecha_llegada, $fecha_salida, $servicios_extra);

    if ($stmt->execute()) {
        echo "Reserva guardada correctamente.";
    } else {
        echo "Error al guardar la reserva: " . $stmt->error;
    }
} else {
    echo "No hay cabañas disponibles del tipo seleccionado.";
}
?>
