<?php
session_start();
include('../db.php'); // conexión con la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde el formulario
    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';

    // Si algún campo está vacío, redirigir con error
    if ($correo === '' || $clave === '') {
        header("Location: login.php?error=2");
        exit();
    }

    // Buscar el usuario por correo
    $stmt = $conn->prepare("SELECT cod_cliente, nombre, contraseña FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // Verificar contraseña (usa password_hash en el registro)
        if (password_verify($clave, $user['contraseña'])) {
            // Crear sesión del usuario
            $_SESSION['cod_cliente'] = $user['cod_cliente'];
            $_SESSION['nombre'] = $user['nombre'];

            // Redirigir a la página de reservas
            $redirect = !empty($_POST['redirect']) ? $_POST['redirect'] : 'reservar.php';
            header("Location: $redirect");
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: login.php?error=2");
        exit();
    }
}
?>
