<?php
include('../db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener las fotos actuales
    $result = mysqli_query($conn, "SELECT foto1, foto2, foto3, foto4 FROM Cabanas WHERE cod_cabana='$id'");
    if ($row = mysqli_fetch_assoc($result)) {
        foreach (['foto1','foto2','foto3','foto4'] as $foto) {
            if(!empty($row[$foto]) && file_exists($row[$foto])){
                unlink($row[$foto]); // eliminar archivo
            }
        }
    }

    // Eliminar registro
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