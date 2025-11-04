<?php
session_start();
include('../db.php');

// Debug: Ver qué está llegando
error_log("=== PROCESAR RESERVA ===");
error_log("POST: " . print_r($_POST, true));

if (!isset($_SESSION['cod_cliente'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: reservar.php");
    exit();
}

// Recibir datos del formulario
$cod_cliente = $_SESSION['cod_cliente'];
$cod_cabana = intval($_POST['cod_cabana']);
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$servicios_extra = trim($_POST['servicios_extra']);
$precio_noche = floatval($_POST['precio_noche']);

error_log("Datos recibidos - Cliente: $cod_cliente, Cabana: $cod_cabana, Servicios: $servicios_extra");

// Validar que las fechas sean válidas
if (empty($fecha_inicio) || empty($fecha_fin)) {
    die("Error: Fechas inválidas");
}

if ($fecha_fin <= $fecha_inicio) {
    die("Error: La fecha de fin debe ser posterior a la fecha de inicio");
}

// Verificar disponibilidad de fechas
$sqlVerificar = "SELECT cod_reserva FROM reservas 
                 WHERE cod_cabana = ? 
                 AND estado IN ('pendiente', 'confirmada')
                 AND ((fecha_inicio BETWEEN ? AND ?) 
                      OR (fecha_fin BETWEEN ? AND ?) 
                      OR (? BETWEEN fecha_inicio AND fecha_fin)
                      OR (? BETWEEN fecha_inicio AND fecha_fin))";
$stmt = $conn->prepare($sqlVerificar);
$stmt->bind_param("issssss", $cod_cabana, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Error: Las fechas seleccionadas no están disponibles. Por favor elige otras fechas.");
}

// Calcular total
$dias = (strtotime($fecha_fin) - strtotime($fecha_inicio)) / (60 * 60 * 24);
$valor_total = $dias * $precio_noche;

// Si no hay servicios extra, poner un valor por defecto
if (empty($servicios_extra)) {
    $servicios_extra = "Sin servicios adicionales";
}

// Insertar reserva - CORREGIDO: sin cod_empleado
$sqlInsert = "INSERT INTO reservas 
              (cod_cliente, cod_cabana, fecha_inicio, fecha_fin, servicios_extra, valor_total, fecha_registro, estado) 
              VALUES (?, ?, ?, ?, ?, ?, CURDATE(), 'pendiente')";
              
$stmt = $conn->prepare($sqlInsert);
$stmt->bind_param("iissid", $cod_cliente, $cod_cabana, $fecha_inicio, $fecha_fin, $servicios_extra, $valor_total);

error_log("SQL a ejecutar: $sqlInsert");

if ($stmt->execute()) {
    $id_reserva = $stmt->insert_id;
    error_log("Reserva creada exitosamente. ID: $id_reserva");
    
    // Redirigir a confirmación
    header("Location: confirmacion_reserva.php?id=" . $id_reserva);
    exit();
} else {
    $error = $conn->error;
    error_log("Error al crear reserva: $error");
    die("Error al procesar la reserva: " . $error);
}
?>