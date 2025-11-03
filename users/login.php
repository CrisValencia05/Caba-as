<?php
session_start();
include('../db.php'); // Conexión con la base de datos

// 🔹 Si hay una sesión activa, verificar que siga siendo válida en la base de datos
if (isset($_SESSION['cod_cliente'])) {
    $id = intval($_SESSION['cod_cliente']);
    $stmt = $conn->prepare("SELECT cod_cliente FROM usuarios WHERE cod_cliente = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        // Sesión válida → redirigir a la página de reservas
        header("Location: reservar.php");
        exit();
    } else {
        // Sesión inválida → limpiar completamente
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Iniciar sesión | New Dawn Glamping</title>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/style.css">
<style>
body {
    background: #f7f8fb;
    font-family: 'Poppins', sans-serif;
}
.container {
    max-width: 420px;
    margin-top: 80px;
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
.btn-primary {
    background-color: #0f2453;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    padding: 10px 0;
}
.btn-primary:hover {
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
    <h3>Iniciar sesión</h3>

    <!-- Mensajes de error -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger mt-3">
            <?php
            if ($_GET['error'] == 1) echo "Contraseña incorrecta.";
            elseif ($_GET['error'] == 2) echo "Usuario no encontrado.";
            ?>
        </div>
    <?php endif; ?>

    <form action="validar_login.php" method="POST">
        <!-- Campo oculto si hay redirect -->
        <?php if (isset($_GET['redirect'])): ?>
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect']); ?>">
        <?php endif; ?>

        <div class="form-group mt-3">
            <label for="correo">Correo electrónico</label>
            <input id="correo" name="correo" type="email" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="clave">Contraseña</label>
            <input id="clave" name="clave" type="password" class="form-control" required>
        </div>

        <button class="btn btn-primary btn-block mt-4" type="submit">Ingresar</button>
    </form>

    <p class="text-center mt-3">
        ¿No tienes cuenta?
        <a href="registro.php">Regístrate</a>
    </p>
</div>
</body>
</html>
