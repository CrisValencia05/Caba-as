<?php
session_start();
include('../db.php');

if (!isset($_SESSION['cod_cliente'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: reservar.php");
    exit();
}

$id_reserva = intval($_GET['id']);
$sql = "SELECT r.*, c.nombre as nombre_cabana, c.precio_noche 
        FROM reservas r 
        JOIN cabanas c ON r.cod_cabana = c.cod_cabana 
        WHERE r.cod_reserva = ? AND r.cod_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_reserva, $_SESSION['cod_cliente']);
$stmt->execute();
$reserva = $stmt->get_result()->fetch_assoc();

if (!$reserva) {
    die("Reserva no encontrada");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva - Masaya</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        body { background:#f7f8fb; padding:50px 20px; }
        .confirmacion { max-width:600px; margin:0 auto; background:white; padding:40px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1); text-align:center; }
        .icono-exito { font-size:80px; color:#28a745; margin-bottom:20px; }
        .btn-volver { background:#0f2453; color:white; padding:10px 25px; border-radius:25px; text-decoration:none; display:inline-block; margin-top:20px; }
    </style>
</head>
<body>

<div class="confirmacion">
    <div class="icono-exito">✅</div>
    <h2 style="color:#0f2453;">¡Reserva Exitosa!</h2>
    <p>Tu reserva ha sido procesada correctamente.</p>
    
    <div style="text-align:left; background:#f8f9fa; padding:20px; border-radius:10px; margin:20px 0;">
    <h5>Detalles de la Reserva:</h5>
    <p><strong>Cabaña:</strong> <?php echo htmlspecialchars($reserva['nombre_cabana']); ?></p>
    <p><strong>Fecha de inicio:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_inicio'])); ?></p>
    <p><strong>Fecha de fin:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_fin'])); ?></p>
    <p><strong>Servicios:</strong> <?php echo nl2br(htmlspecialchars($reserva['servicios_extra'])); ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($reserva['valor_total'], 2); ?></p>
    <p><strong>Estado:</strong> <span style="color:#ffc107;"><?php echo ucfirst($reserva['estado']); ?></span></p>
    </div>

    <a href="reservar.php" class="btn-volver">Volver a Cabañas</a>
</div>

</body>
</html>