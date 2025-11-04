<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $capacidad = intval($_POST['capacidad']);
    $precio = floatval($_POST['precio_noche']);
    $caracteristicas = mysqli_real_escape_string($conn, $_POST['caracteristicas']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);
    $foto_actual = $_POST['foto_actual'];
    
    $foto = $foto_actual; // Por defecto, mantener la foto actual

    // Manejar nueva foto si se subió
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $uploadDir = '../images/';
        
        // Eliminar foto anterior si existe
        if(!empty($foto_actual) && file_exists($uploadDir . $foto_actual)) {
            unlink($uploadDir . $foto_actual);
        }
        
        // Subir nueva foto
        $fileName = uniqid() . '_' . basename($_FILES['foto']['name']);
        $filePath = $uploadDir . $fileName;
        
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $filePath)) {
            $foto = $fileName;
        }
    }

    // Actualizar en la base de datos
    $sql = "UPDATE Cabanas SET
                nombre='$nombre',
                capacidad='$capacidad',
                precio_noche='$precio',
                caracteristicas='$caracteristicas',
                estado='$estado',
                foto='$foto'
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