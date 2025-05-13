<?php
include '../db.php';
session_start();

$nombre1 = $_POST['nombre1'] ?? '';
$nombre2 = $_POST['nombre2'] ?? '';
$apellido1 = $_POST['apellido1'] ?? '';
$apellido2 = $_POST['apellido2'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);

// Verificar si el correo ya existe
$check = $conn->prepare("SELECT cliente_id FROM clientes WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("Este correo ya está registrado. <a href='login_users.php'>Inicia sesión</a>");
}

// Insertar nuevo usuario
$stmt = $conn->prepare("INSERT INTO clientes (nombre1, nombre2, apellido1, apellido2, email, password, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $nombre1, $nombre2, $apellido1, $apellido2, $email, $password, $telefono);

if ($stmt->execute()) {
    // Iniciar sesión para el usuario recién registrado
    $_SESSION['cliente_id'] = $conn->insert_id;  // Guardamos el ID del usuario en la sesión
    $_SESSION['email'] = $email;  // Guardamos el email en la sesión (opcional)
    header("Location: reservation.php");
    exit;
} else {
    echo "Error al registrar: " . $stmt->error;
}
?>
