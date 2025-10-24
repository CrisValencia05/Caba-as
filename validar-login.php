<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include("db.php"); // Conexión a la base de datos

$correo = $_POST['correo'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

// Depuración rápida
if(empty($correo) || empty($contrasena)){
    die("Debes ingresar correo y contraseña");
}

$query = "SELECT * FROM Empleado WHERE correo = '$correo' AND contrasena = '$contrasena'";
$resultado = mysqli_query($conn, $query);

// Verificar errores SQL
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

if(mysqli_num_rows($resultado) == 1){
    $admin = mysqli_fetch_assoc($resultado);
    $_SESSION['correo'] = $admin['correo'];
    $_SESSION['user'] = $admin['nombre'];
    header("Location: admin/home.php");
    exit();
} else {
    echo "<script>
            alert('Credencial o contraseña incorrectos.');
            window.location.href = 'login.php';
          </script>";
}
?>