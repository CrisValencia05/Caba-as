<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $capacidad = intval($_POST['capacidad']);
    $precio = floatval($_POST['precio_noche']);
    $caracteristicas = mysqli_real_escape_string($conn, $_POST['caracteristicas']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);

    // Obtener fotos actuales para reemplazo si se cargan nuevas
    $result = mysqli_query($conn, "SELECT foto1, foto2, foto3, foto4 FROM Cabanas WHERE cod_cabana='$id'");
    $row = mysqli_fetch_assoc($result);
    $fotos_actuales = [$row['foto1'], $row['foto2'], $row['foto3'], $row['foto4']];

    $fotos_nuevas = $fotos_actuales;

    // Manejar subida de nuevas fotos
    if(isset($_FILES['fotos'])) {
        $uploadDir = 'uploads/';
        foreach($_FILES['fotos']['tmp_name'] as $key => $tmpName){
            if($_FILES['fotos']['error'][$key] === 0){
                // Borrar foto anterior si existe
                if(!empty($fotos_actuales[$key]) && file_exists($fotos_actuales[$key])){
                    unlink($fotos_actuales[$key]);
                }
                $fileName = uniqid() . '_' . $_FILES['fotos']['name'][$key];
                move_uploaded_file($tmpName, $uploadDir . $fileName);
                $fotos_nuevas[$key] = $uploadDir . $fileName;
            }
        }
    }

    $sql = "UPDATE Cabanas SET
                nombre='$nombre',
                capacidad='$capacidad',
                precio_noche='$precio',
                caracteristicas='$caracteristicas',
                estado='$estado',
                foto1='".($fotos_nuevas[0] ?? null)."',
                foto2='".($fotos_nuevas[1] ?? null)."',
                foto3='".($fotos_nuevas[2] ?? null)."',
                foto4='".($fotos_nuevas[3] ?? null)."'
            WHERE cod_cabana='$id'";

    if(mysqli_query($conn, $sql)) {
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