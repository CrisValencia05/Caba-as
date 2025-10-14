<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $apellido = $_POST['apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $cargo = $_POST['cargo'];
    $salario = $_POST['salario'];

    // Buscar el cod_cargo según el nombre del cargo
    $cargoQuery = mysqli_query($conn, "SELECT cod_cargo FROM CargoEmpleado WHERE nombre = '$cargo' LIMIT 1");
    if (mysqli_num_rows($cargoQuery) > 0) {
        $cargoRow = mysqli_fetch_assoc($cargoQuery);
        $cod_cargo = $cargoRow['cod_cargo'];
    } else {
        // Si el cargo no existe, crear uno nuevo
        mysqli_query($conn, "INSERT INTO CargoEmpleado (nombre, salario) VALUES ('$cargo', '$salario')");
        $cod_cargo = mysqli_insert_id($conn);
    }

    // Actualizar empleado
    $update = "UPDATE Empleado 
               SET nombre='$nombre', segundo_nombre='$segundo_nombre', apellido='$apellido',
                   segundo_apellido='$segundo_apellido', celular='$celular', direccion='$direccion',
                   correo='$correo', cod_cargo='$cod_cargo'
               WHERE cod_empleado='$id'";

    if (mysqli_query($conn, $update)) {
        echo "<script>
                alert('✅ Empleado actualizado correctamente');
                window.location.href = 'vista_empleados.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error al actualizar el empleado');
                window.location.href = 'vista_empleados.php';
              </script>";
    }
} else {
    header("Location: vista_empleados.php");
    exit();
}
?>