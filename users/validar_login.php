<?php
session_start();
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if ($correo === '' || $clave === '') {
        header("Location: login.php?error=2");
        exit();
    }

    $stmt = $conn->prepare("SELECT cod_cliente, nombre, contraseña FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();

        if (password_verify($clave, $user['contraseña'])) {
            $_SESSION['cod_cliente'] = $user['cod_cliente'];
            $_SESSION['nombre'] = $user['nombre'];

            $redirect = !empty($_POST['redirect']) ? $_POST['redirect'] : 'reservar.php';
            header("Location: $redirect");
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        header("Location: login.php?error=2");
        exit();
    }
}
?>