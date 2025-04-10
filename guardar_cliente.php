<?php
// Conectarse a la base de datos
include("admin/db.php"); // Ajusta esta ruta si tu archivo db.php está en otra carpeta

// Capturar los datos del formulario
$nombre1   = $_POST['nombre1'];
$nombre2   = $_POST['nombre2'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$email     = $_POST['email'];
$password  = $_POST['password'];
$telefono  = $_POST['telefono'];

// Insertar en la base de datos
$sql = "INSERT INTO clientes (nombre1, nombre2, apellido1, apellido2, email, password, telefono)
        VALUES ('$nombre1', '$nombre2', '$apellido1', '$apellido2', '$email', '$password', '$telefono')";

if (mysqli_query($conn, $sql)) {
    echo "Registro exitoso.";
} else {
    echo "Error al registrar: " . mysqli_error($conn);
}
?>