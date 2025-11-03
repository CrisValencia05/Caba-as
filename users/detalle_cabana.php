<?php
session_start();
include('../db.php');

// Validar sesión: si no está logueado, redirigir al login
if (!isset($_SESSION['cod_cliente'])) {
    header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

// Verificar que venga un ID válido
if (!isset($_GET['id'])) {
    header("Location: reservar.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM cabanas WHERE cod_cabana = $id";
$res = $conn->query($sql);

if (!$res || $res->num_rows === 0) {
    header("Location: reservar.php");
    exit();
}

$cabana = $res->fetch_assoc();
$img_num = ($id % 4 === 0) ? 4 : $id % 4;
$img = "../images/r{$img_num}.jpg";
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Cabaña - Masaya</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <style>
        body { background:#f7f8fb; }
        .detalle-container { display:flex; flex-wrap:wrap; max-width:1100px; margin:60px auto; background:#fff; box-shadow:0 6px 20px rgba(0,0,0,0.1); border-radius:12px; overflow:hidden; }
        .detalle-img { flex:1 1 45%; min-width:300px; }
        .detalle-img img { width:100%; height:100%; object-fit:cover; display:block; }
        .detalle-info { flex:1 1 55%; padding:40px; }
        .detalle-info h2 { color:#0f2453; font-weight:700; margin-bottom:10px; }
        .detalle-info p { color:#333; margin-bottom:20px; }
        .form-label { font-weight:600; color:#0f2453; }
        .btn-reservar { background:#0f2453; color:white; padding:10px 20px; border:none; border-radius:25px; font-weight:600; transition:0.3s; }
        .btn-reservar:hover { background:#132e6b; }
        .select-servicio { border-radius:25px; padding:8px 12px; width:100%; border:1px solid #ccc; }
        @media(max-width:768px) {
            .detalle-container { flex-direction:column; }
            .detalle-info { padding:25px; }
        }
    </style>
</head>
<body>

<nav style="background:#0f2453; padding:12px 0;">
    <div class="container" style="display:flex; justify-content:space-between; align-items:center;">
        <a href="../index.php" style="color:#fff; font-weight:700; font-size:20px; text-decoration:none;">MASAYA <span style="color:#ffd700;">GLAMING</span></a>
        <div>
            <a href="../index.php" style="color:#fff; margin-right:12px; text-decoration:none;">Inicio</a>
            <a href="reservar.php" style="color:#fff; margin-right:12px; text-decoration:none;">Cabañas</a>
            <a href="login.php" style="color:#fff; margin-left:12px; text-decoration:none;">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="detalle-container">
    <div class="detalle-img">
        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($cabana['nombre']); ?>">
    </div>
    <div class="detalle-info">
        <h2><?php echo htmlspecialchars($cabana['nombre']); ?></h2>
        <p><strong>Capacidad:</strong> <?php echo htmlspecialchars($cabana['capacidad']); ?> personas</p>
        <p><strong>Características:</strong> <?php echo htmlspecialchars($cabana['caracteristicas']); ?></p>
        <h4 style="color:#e60000;">$<?php echo number_format($cabana['precio_noche'], 2); ?> / noche</h4>

```
    <form action="procesar_reserva.php" method="POST" style="margin-top:20px;">
        <input type="hidden" name="cod_cabana" value="<?php echo $cabana['cod_cabana']; ?>">

        <div class="form-group">
            <label class="form-label">Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" class="form-control" required>
        </div>

        <div class="form-group">
            <label class="form-label">Fecha de fin:</label>
            <input type="date" name="fecha_fin" class="form-control" required>
        </div>

        <div class="form-group">
            <label class="form-label">Servicios adicionales:</label>
            <select name="servicios_extra" class="select-servicio" required>
                <option value="">Seleccione un servicio</option>
                <option value="Desayuno incluido">Desayuno incluido</option>
                <option value="Jacuzzi privado">Jacuzzi privado</option>
                <option value="Paseo ecológico">Paseo ecológico</option>
                <option value="Decoración romántica">Decoración romántica</option>
                <option value="Transporte al sitio">Transporte al sitio</option>
            </select>
        </div>

        <button type="submit" class="btn-reservar">Reservar</button>
    </form>
</div>
```

</div>

</body>
</html>
