<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "cabañas";

$conn = mysqli_connect($host, $user, $password, $database);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>