<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ingreso Admin</title>
  <link rel="stylesheet" href="css/styles.css"> <!-- si tienes archivo CSS -->
</head>
<body>
  <h2>Bienvenido, ingresa tus credenciales: </h2>
  <form action="validar-login.php" method="POST">
    <label for="correo">Codigo de empleado: </label>
    <input type="text" name="correo" required><br><br>

    <label for="contrasena">Contraseña: </label>
    <input type="password" name="contrasena" required><br><br>

    <button type="submit">Ingresar</button>
  </form>
</body>
</html>