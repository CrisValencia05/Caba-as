<?php
include("admin/db.php"); // Conexión a la base de datos

// Capturamos los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta para verificar si el administrador existe
$query = "SELECT * FROM empleados WHERE email = '$email' AND contraseña = '$password'";
$resultado = mysqli_query($conn, $query);

// Verificamos si hay coincidencias
if(mysqli_num_rows($resultado) == 1){
    // El administrador existe
    session_start();
    $admin = mysqli_fetch_assoc($resultado);
    $_SESSION['email'] = $admin['email'];
    $_SESSION['user'] = $admin['nombre']; // Guardamos el nombre
    header("Location: admin/home.php"); // Redirige al panel de administración
    exit();
} else {
    // El administrador no existe
    echo "<script>
            alert('Correo o contraseña incorrectos.');
            window.location.href = 'login.php';
          </script>";
}
?>