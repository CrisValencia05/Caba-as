
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">

</head>
<body>
    <div class="container">
    <h2>Iniciar sesión</h2>
    <form action="validar_login_users.php" method="post">
        <input type="email" name="email" placeholder="Correo electrónico" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <input type="submit" value="Entrar">
    </form>
    <p>¿No tienes cuenta? <a href="users.php">Regístrate</a></p>
    </div>
</body>
</html>
