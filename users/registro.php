<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre           = mysqli_real_escape_string($conn, $_POST['nombre']);
    $segundo_nombre   = mysqli_real_escape_string($conn, $_POST['segundo_nombre']);
    $apellido         = mysqli_real_escape_string($conn, $_POST['apellido']);
    $segundo_apellido = mysqli_real_escape_string($conn, $_POST['segundo_apellido']);
    $correo           = mysqli_real_escape_string($conn, $_POST['correo']);
    $celular          = mysqli_real_escape_string($conn, $_POST['celular']);
    $direccion        = mysqli_real_escape_string($conn, $_POST['direccion']);
    $contrasena       = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, segundo_nombre, apellido, segundo_apellido, celular, direccion, correo, contraseña, fecha_registro)
            VALUES ('$nombre', '$segundo_nombre', '$apellido', '$segundo_apellido', '$celular', '$direccion', '$correo', '$contrasena', NOW())";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "❌ Error al registrar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de Usuario | New Dawn Glamping</title>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/font-awesome.css">
<style>
    body {
        background: #f7f8fb;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 500px;
        margin: 80px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    h3 {
        text-align: center;
        color: #0f2453;
        font-weight: 700;
        margin-bottom: 25px;
    }
    label {
        font-weight: 500;
        color: #333;
    }
    .form-control {
        border-radius: 8px;
        margin-bottom: 15px;
    }
    .btn-success {
        background-color: #0f2453;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        padding: 10px 0;
    }
    .btn-success:hover {
        background-color: #132e6b;
    }
    .text-center a {
        color: #0f2453;
        text-decoration: none;
        font-weight: 500;
    }
    .text-center a:hover {
        color: #ffd700;
    }
</style>
</head>

<body>
    <div class="container">
        <h3>Registro de Usuario</h3>
        <form method="POST">
            <label>Primer Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>

            <label>Segundo Nombre:</label>
            <input type="text" name="segundo_nombre" class="form-control">

            <label>Primer Apellido:</label>
            <input type="text" name="apellido" class="form-control" required>

            <label>Segundo Apellido:</label>
            <input type="text" name="segundo_apellido" class="form-control">

            <label>Correo Electrónico:</label>
            <input type="email" name="correo" class="form-control" required>

            <label>Celular:</label>
            <input type="text" name="celular" class="form-control" required>

            <label>Dirección:</label>
            <input type="text" name="direccion" class="form-control" required>

            <label>Contraseña:</label>
            <input type="password" name="contraseña" class="form-control" required>

            <button type="submit" class="btn btn-success btn-block">Registrar</button>
        </form>

        <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
