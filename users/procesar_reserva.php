<?php
session_start();
include('../db.php');

// Verificar si hay un usuario logueado
if (!isset($_SESSION['cod_cliente'])) {
    header("Location: login.php?redirect=reservar.php");
    exit();
}

// Verificar si el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_cliente = $_SESSION['cod_cliente'];
    $cod_cabana = intval($_POST['cod_cabana']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $servicios_extra = mysqli_real_escape_string($conn, $_POST['servicios_extra']);
    $fecha_registro = date("Y-m-d");

    // Validar que la fecha de fin sea posterior a la de inicio
    if ($fecha_fin <= $fecha_inicio) {
        echo "<script>alert('La fecha de fin debe ser posterior a la de inicio.'); window.history.back();</script>";
        exit();
    }

    // Calcular valor total: obtener precio de la cabaña
    $consulta_precio = $conn->prepare("SELECT precio_noche FROM cabanas WHERE cod_cabana = ?");
    $consulta_precio->bind_param("i", $cod_cabana);
    $consulta_precio->execute();
    $resultado = $consulta_precio->get_result();
    $cabana = $resultado->fetch_assoc();

    if (!$cabana) {
        echo "<script>alert('Error: La cabaña seleccionada no existe.'); window.history.back();</script>";
        exit();
    }

    // Calcular noches y valor total
    $dias = (strtotime($fecha_fin) - strtotime($fecha_inicio)) / 86400;
    $valor_total = $dias * $cabana['precio_noche'];

    // Insertar reserva en la base de datos
    $sql = "INSERT INTO reservas (cod_cliente, cod_cabana, fecha_inicio, fecha_fin, fecha_registro, servicios_extra, valor_total)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssd", $cod_cliente, $cod_cabana, $fecha_inicio, $fecha_fin, $fecha_registro, $servicios_extra, $valor_total);

    if ($stmt->execute()) {
        echo "<script>
                alert('¡Reserva realizada con éxito!');
                window.location.href = 'reservar.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al guardar la reserva. Inténtalo nuevamente.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Si no vino por POST, redirigir
    header("Location: reservar.php");
    exit();
}
?>
