<?php
session_start();
$con = new mysqli("localhost", "root", "", "glamping");

if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $con->prepare("SELECT cliente_id, nombre1, password FROM clientes WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($cliente_id, $nombre1, $hash);
    $stmt->fetch();

    // Verificar la contraseña
    if (password_verify($password, $hash)) {
        // Establecer las variables de sesión
        $_SESSION['usuario_id'] = $cliente_id;   // Guardar ID de cliente en sesión
        $_SESSION['usuario_nombre'] = $nombre1; 
        $_SESSION['email'] = $email; // Esto es clave  // Guardar nombre en sesión
        if(isset($_SESSION['usuario_id'])) {
            echo "Sesión iniciada correctamente";
        }
        header("Location: reservation.php");
        exit;
    } else {
        echo "Contraseña incorrecta. <a href='login_users.php'>Intenta nuevamente</a>";
    }
} else {
    echo "Correo no registrado. <a href='register_users.php'>Regístrate</a>";
}
?>
