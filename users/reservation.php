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
</head>
<body>
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

        <button type="submit">Reservar</button>
    </form>

    <hr>

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
            echo "<li>{$row['fecha_solicitud']} - {$row['cabana_nombre']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No tienes reservas registradas.";
    }
    ?>
    <form action="logout.php" method="post" style="text-align:right;">
    <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
