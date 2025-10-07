<?php
$con = mysqli_connect("localhost","root","","glamping_db") or die(mysqli_error($con));

// Verificar si la conexión fue exitosa
if (mysqli_connect_errno()) {
    // Si hay un error en la conexión, muestra un mensaje detallado
    die("Fallo la conexión a la base de datos: " . mysqli_connect_error());
}
?>
