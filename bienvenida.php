<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bienvenido</title>
</head>
<body>
  <h2>¡Hola, bienvenido!</h2>
  <p>Has iniciado sesión correctamente como: <?php echo $_SESSION['email']; ?></p>
</body>
</html>