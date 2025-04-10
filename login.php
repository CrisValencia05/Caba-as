<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ingreso de Clientes</title>
  <link rel="stylesheet" href="css/styles.css"> <!-- si tienes archivo CSS -->
</head>
<body>
  <h2>Ingresar</h2>
  <form action="validar-login.php" method="POST">
    <label for="email">Correo electrónico:</label>
    <input type="email" name="email" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Ingresar</button>
  </form>
</body>
</html>