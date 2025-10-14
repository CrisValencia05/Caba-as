<?php
include('../db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Empleado WHERE cod_empleado = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('🗑️ Empleado eliminado correctamente');
                window.location.href = 'vista_empleados.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al eliminar el empleado');
                window.location.href = 'vista_empleados.php';
              </script>";
    }
} else {
    header("Location: vista_empleados.php");
    exit();
}
?>