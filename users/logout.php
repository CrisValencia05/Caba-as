<?php
session_start();

// 🔹 Destruir todas las variables de sesión
$_SESSION = [];

// 🔹 Si hay cookie de sesión, eliminarla también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 🔹 Destruir la sesión completamente
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sesión cerrada | New Dawn Glamping</title>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/style.css">
<style>
body {
    background: #f7f8fb;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    text-align: center;
    max-width: 420px;
}
h3 {
    color: #0f2453;
    font-weight: 700;
    margin-bottom: 20px;
}
p {
    color: #333;
    margin-bottom: 30px;
}
.btn {
    background-color: #0f2453;
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    color: #fff;
    font-weight: 600;
}
.btn:hover {
    background-color: #132e6b;
}
</style>
</head>
<body>
<div class="container">
    <h3>Sesión cerrada exitosamente</h3>
    <p>Tu sesión se ha cerrado correctamente.</p>
    <a href="../index.php" class="btn">Volver al inicio</a>
</div>
</body>
</html>
