<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <h2>Registro</h2>
    <form action="save_users.php" method="post">
        <input type="text" name="nombre1" placeholder="Nombre" required><br><br>
        <input type="text" name="nombre2" placeholder="Segundo Nombre" required><br><br>
        <input type="text" name="apellido1" placeholder="apellido" required><br><br>
        <input type="text" name="apellido2" placeholder="Segundo apellido" required><br><br>
        <input type="email" name="email" placeholder="Correo electrónico" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <input type="phone" name="telefono" placeholder="telefono" required><br><br>
        <input type="submit" value="Registrarse">
    </form>
    <p>¿Ya tienes cuenta? <a href="login_users.php">Inicia sesión</a></p>
    </div>
</body>
</html>