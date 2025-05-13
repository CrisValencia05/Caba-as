<?php
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión
header("Location: ../index.php"); // Redirige al apartado principal (ajusta si tu archivo principal tiene otro nombre o ruta)
exit;
?>