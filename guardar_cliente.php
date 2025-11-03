<?php
// Mostrar errores mientras depuramos (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php'); // tu conexión a la base de datos (misma carpeta)

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Acceso no permitido.";
    exit;
}

// Obtener datos del formulario
$nombre           = mysqli_real_escape_string($conn, $_POST['nombre'] ?? '');
$segundo_nombre   = mysqli_real_escape_string($conn, $_POST['segundo_nombre'] ?? '');
$apellido         = mysqli_real_escape_string($conn, $_POST['apellido'] ?? '');
$segundo_apellido = mysqli_real_escape_string($conn, $_POST['segundo_apellido'] ?? '');
$correo           = mysqli_real_escape_string($conn, $_POST['correo'] ?? '');
$celular          = mysqli_real_escape_string($conn, $_POST['celular'] ?? '');
$direccion        = mysqli_real_escape_string($conn, $_POST['direccion'] ?? '');
$contrasena_raw   = $_POST['contrasena'] ?? ''; // debe coincidir con name="contrasena" en el form

// Validar campos obligatorios
if (empty($nombre) || empty($apellido) || empty($correo) || empty($contrasena_raw)) {
    echo "<script>alert('Por favor completa los campos obligatorios.'); window.history.back();</script>";
    exit;
}

// Encriptar la contraseña
$password_hash = password_hash($contrasena_raw, PASSWORD_BCRYPT);

// Nombre de la tabla
$table = 'usuarios';

// Consulta SQL con prepared statement
$sql = "INSERT INTO `$table` 
(`nombre`, `segundo_nombre`, `apellido`, `segundo_apellido`, `celular`, `direccion`, `correo`, `contraseña`, `fecha_registro`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo "Error al preparar la consulta: " . mysqli_error($conn);
    exit;
}

// Vincular parámetros
mysqli_stmt_bind_param($stmt, 'ssssssss',
    $nombre,
    $segundo_nombre,
    $apellido,
    $segundo_apellido,
    $celular,
    $direccion,
    $correo,
    $password_hash
);

// Ejecutar e identificar errores específicos
if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('✅ Registro exitoso. ¡Bienvenido a Masaya!'); window.location='index.php';</script>";
    exit;
} else {
    if (mysqli_errno($conn) == 1062) {
        echo "<script>alert('❌ Este correo ya está registrado. Intenta con otro.'); window.history.back();</script>";
    } else {
        echo "<script>alert('⚠️ Error al registrar: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
    }
    exit;
}
?>