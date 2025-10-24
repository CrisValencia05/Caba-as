<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio_noche'];

    $sql = "UPDATE Cabanas SET nombre='$nombre', capacidad='$capacidad', precio_noche='$precio'
            WHERE cod_cabana='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('✅ Cabaña actualizada correctamente');
                window.location.href = 'room.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al actualizar la cabaña');
                window.location.href = 'room.php';
              </script>";
    }
} else {
    header("Location: room.php");
    exit();
}
?>