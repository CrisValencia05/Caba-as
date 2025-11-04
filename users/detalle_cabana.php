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
$sql = "SELECT * FROM cabanas WHERE cod_cabana = $id AND estado = 'activa'";
$res = $conn->query($sql);

if (!$res || $res->num_rows === 0) {
    header("Location: reservar.php");
    exit();
}

$cabana = $res->fetch_assoc();

// Manejar la imagen desde la BD
if (!empty($cabana['foto'])) {
    $img = "data:image/jpeg;base64," . base64_encode($cabana['foto']);
} else {
    $img_num = ($id % 4 === 0) ? 4 : $id % 4;
    $img = "../images/r{$img_num}.jpg";
}

// Procesar fechas no disponibles
$fechasOcupadas = [];
$sqlFechas = "SELECT fecha_inicio, fecha_fin FROM reservas 
              WHERE cod_cabana = $id 
              AND estado IN ('pendiente', 'confirmada')
              AND fecha_fin >= CURDATE()";
$resFechas = $conn->query($sqlFechas);

while ($fecha = $resFechas->fetch_assoc()) {
    $fechasOcupadas[] = [
        'inicio' => $fecha['fecha_inicio'],
        'fin' => $fecha['fecha_fin']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Cabaña - Masaya</title>
    <link rel="icon" type="image/png" href="../images/cropped-logo-masaya-experience-2024-32x32.png">
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
        .fechas-ocupadas { background:#fff4f4; border:1px solid #ffcccc; border-radius:8px; padding:15px; margin:15px 0; }
        .fechas-ocupadas h5 { color:#d63031; margin-bottom:10px; }
        .fecha-item { color:#666; font-size:14px; margin:5px 0; }
        .alert { padding:10px; border-radius:5px; margin:10px 0; }
        .alert-warning { background:#fff3cd; border:1px solid #ffeaa7; color:#856404; }
        @media(max-width:768px) {
            .detalle-container { flex-direction:column; }
            .detalle-info { padding:25px; }
        }
    </style>
</head>
<body>

<nav style="background:#0f2453; padding:12px 0;">
    <div class="container" style="display:flex; justify-content:space-between; align-items:center;">
        <a href="../index.php" style="color:#fff; font-weight:700; font-size:20px; text-decoration:none;">MASAYA <span style="color:#ffd700;">GLAMPING</span></a>
        <div>
            <a href="../index.php" style="color:#fff; margin-right:12px; text-decoration:none;">Inicio</a>
            <a href="reservar.php" style="color:#fff; margin-right:12px; text-decoration:none;">Cabañas</a>
            <a href="logout.php" style="color:#fff; margin-left:12px; text-decoration:none;">Cerrar sesión</a>
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

        <!-- Mostrar fechas ocupadas -->
        <?php if (!empty($fechasOcupadas)): ?>
        <div class="fechas-ocupadas">
            <h5>⚠️ Fechas No Disponibles</h5>
            <?php foreach ($fechasOcupadas as $fecha): ?>
                <div class="fecha-item">
                    📅 <?php echo date('d/m/Y', strtotime($fecha['inicio'])); ?> 
                    al <?php echo date('d/m/Y', strtotime($fecha['fin'])); ?>
                </div>
            <?php endforeach; ?>
            <small style="color:#666;">Estas fechas ya están reservadas</small>
        </div>
        <?php endif; ?>

        <!-- 🔹 Formulario de Reserva -->
            <form action="procesar_reserva.php" method="POST" style="margin-top:20px;" id="formReserva">
                <input type="hidden" name="cod_cabana" value="<?php echo $cabana['cod_cabana']; ?>">
                <input type="hidden" name="precio_noche" value="<?php echo $cabana['precio_noche']; ?>">

                <div class="form-group">
                    <label class="form-label">Fecha de inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required 
                        min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha de fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required 
                        min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Servicios adicionales:</label>
                    <textarea name="servicios_extra" class="form-control" rows="3" 
                            placeholder="Ej: Desayuno incluido, Jacuzzi privado, Transporte al sitio, Decoración especial..."></textarea>
                    <small class="text-muted">Describe los servicios adicionales que deseas incluir en tu reserva</small>
                </div>

                <div id="mensajeError" class="alert alert-warning" style="display:none;"></div>

                <button type="submit" class="btn-reservar" id="btnReservar">Reservar</button>
            </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');
    const mensajeError = document.getElementById('mensajeError');
    const btnReservar = document.getElementById('btnReservar');
    const formReserva = document.getElementById('formReserva');

    // Cuando cambia la fecha de inicio, actualizar el mínimo de fecha fin
    fechaInicio.addEventListener('change', function() {
        if (fechaInicio.value) {
            fechaFin.min = fechaInicio.value;
            if (fechaFin.value && fechaFin.value < fechaInicio.value) {
                fechaFin.value = fechaInicio.value;
            }
        }
    });

    // Validar fechas antes de enviar
    formReserva.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!fechaInicio.value || !fechaFin.value) {
            mostrarError('Por favor selecciona ambas fechas');
            return;
        }

        if (fechaFin.value <= fechaInicio.value) {
            mostrarError('La fecha de fin debe ser posterior a la fecha de inicio');
            return;
        }

        // Si pasa todas las validaciones, enviar formulario
        this.submit();
    });

    function mostrarError(mensaje) {
        mensajeError.textContent = mensaje;
        mensajeError.style.display = 'block';
        setTimeout(() => {
            mensajeError.style.display = 'none';
        }, 5000);
    }
});
</script>

</body>
</html>