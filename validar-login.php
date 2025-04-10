<?php
include("admin/db.php"); // Conexión a la base de datos

// Capturamos los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta para verificar si el cliente existe
$query = "SELECT * FROM clientes WHERE email = '$email' AND password = '$password'";
$resultado = mysqli_query($conn, $query);

// Verificamos si hay coincidencias
if(mysqli_num_rows($resultado) == 1){
    // El cliente existe
    session_start();
    $_SESSION['email'] = $email;
    header("Location: bienvenida.php"); // redirige a una página de bienvenida
} else {
    // El cliente no existe
    echo "<script>
            alert('Correo o contraseña incorrectos.');
            window.location.href = 'login.php';
          </script>";
}
?>