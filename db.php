<?php
$conn = mysqli_connect("localhost", "root", "", "glamping_db");

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
?>
