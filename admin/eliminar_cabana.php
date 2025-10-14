<?php
include('../db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM Cabanas WHERE cod_cabana = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('🗑️ Cabaña eliminada correctamente');
                window.location.href = 'room.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al eliminar la cabaña');
                window.location.href = 'room.php';
              </script>";
    }
} else {
    header("Location: room.php");
    exit();
}
?>