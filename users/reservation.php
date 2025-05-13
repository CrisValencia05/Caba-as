<?php
include('../db.php');
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si no está autenticado, redirigir al login
    header("Location: login_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservar Cabaña</title>
    <link rel="stylesheet" href="../css/reserva.css">
</head>
<body>
    <div class="container">
    <h2>Formulario de Reserva</h2>

    <form action="save_reserva_users.php" method="POST">
        <label for="type">Tipo de Cabaña:</label>
        <select name="type" id="type" required>
            <option value="">Seleccione una opción</option>
            <?php
            // Mostrar las opciones disponibles desde la tabla glamping
            $query = "SELECT type, nombre FROM glamping WHERE disponible = 1";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['type']}'>{$row['nombre']}</option>";
            }
            ?>
        </select>
        <br><br>

    <label for="fecha_llegada">Fecha de llegada:</label>
    <input type="date" name="fecha_llegada" id="fecha_llegada" required><br><br>

    <label for="fecha_salida">Fecha de salida:</label>
    <input type="date" name="fecha_salida" id="fecha_salida" required><br><br>

    <label for="servicios_extra">Servicios extra (comentarios):</label><br>
    <textarea name="servicios_extra" id="servicios_extra" rows="4" cols="40"></textarea><br><br>

        <button type="submit">Reservar</button>
    </form>

    </div>

    <br>

    <div class="reserva">
    <h3>Mis Reservas</h3>
    <?php
    $cliente_id = $_SESSION['usuario_id'];
    $query = "SELECT r.*, g.nombre AS cabana_nombre 
              FROM reservas r 
              JOIN glamping g ON r.cabana_id = g.id 
              WHERE r.cliente_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
        echo "<strong>Cabaña:</strong> {$row['cabana_nombre']}<br>";
        echo "<strong>Fecha de solicitud:</strong> {$row['fecha_solicitud']}<br>";
        echo "<strong>Fecha de llegada:</strong> {$row['fecha_llegada']}<br>";
        echo "<strong>Fecha de salida:</strong> {$row['fecha_salida']}<br>";
        echo "<strong>Servicios extra:</strong>" . (!empty($row['servicios_extra']) ? $row['servicios_extra'] : 'Ninguno');

    
        echo "<form method='POST' action='delete_reserva.php' onsubmit=\"return confirm('¿Estás seguro de eliminar esta reserva?');\">";
        echo "<input type='hidden' name='reserva_id' value='{$row['id']}'>";
        echo "<br><button type='submit'>Eliminar</button>";
        echo "</form>";

        echo "</li><br>";
        }
        echo "</ul>";
    } else {
        echo "No tienes reservas registradas.";
    }
    ?>
    </div>
    <form action="logout.php" method="post" style="text-align:right;">
    <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
