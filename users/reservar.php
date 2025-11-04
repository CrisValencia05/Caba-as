<?php
session_start();
include('../db.php');

if (!isset($_SESSION['cod_cliente'])) {
    header("Location: login.php");
    exit();
}

// Obtener todas las cabañas activas para las tarjetas
$sqlCabanas = "SELECT cod_cabana, nombre, capacidad, caracteristicas, precio_noche, foto 
               FROM cabanas 
               WHERE estado = 'activa' 
               ORDER BY nombre";
$resCabanas = $conn->query($sqlCabanas);

// Obtener las reservas del usuario actual
$cod_cliente = $_SESSION['cod_cliente'];
$sqlReservas = "SELECT r.*, c.nombre as nombre_cabana, c.foto as foto_cabana
                FROM reservas r 
                JOIN cabanas c ON r.cod_cabana = c.cod_cabana 
                WHERE r.cod_cliente = ? 
                ORDER BY r.fecha_inicio DESC";
$stmt = $conn->prepare($sqlReservas);
$stmt->bind_param("i", $cod_cliente);
$stmt->execute();
$reservas = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mapa de Cabañas - Masaya Glamping</title>
    <link rel="icon" type="image/png" href="../images/cropped-logo-masaya-experience-2024-32x32.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <style>
        body {
            margin: 0;
            background: #f7f8fb;
            font-family: 'Poppins', sans-serif;
        }

        /* --- Barra superior --- */
        nav {
            background: #0f2453;
            padding: 12px 0;
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        nav .container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 12px;
            font-weight: 500;
        }
        nav a:hover {
            color: #ffd700;
        }
        nav .brand {
            font-weight: 700;
            font-size: 20px;
        }

        /* --- Contenedor principal --- */
        .map-container {
            position: relative;
            margin-top: 90px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .map-image {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        /* --- Iconos de cabañas --- */
        .cabin-marker {
            position: absolute;
            cursor: pointer;
            transform: translate(-50%, -100%);
            transition: transform 0.2s;
            z-index: 100;
        }
        .cabin-marker:hover {
            transform: translate(-50%, -110%) scale(1.1);
        }
        .cabin-marker i {
            font-size: 28px;
            color: #0f2453;
            text-shadow: 0 0 6px rgba(255,255,255,0.8);
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        /* --- Tooltip de cabaña --- */
        .tooltip-cabana {
            display: none;
            position: absolute;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            padding: 10px 15px;
            width: 180px;
            z-index: 110;
            text-align: center;
            transform: translate(-50%, -120%);
            border: 2px solid #0f2453;
        }
        .tooltip-cabana h5 {
            margin: 0;
            font-size: 15px;
            color: #0f2453;
            font-weight: 700;
        }
        .tooltip-cabana p {
            margin: 5px 0 0;
            color: #555;
            font-size: 13px;
        }

        /* --- Modal detalle --- */
        .modal-cabana {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }
        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 700px;
            width: 90%;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .modal-header {
            background: #0f2453;
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-body {
            padding: 25px;
        }
        .close-btn {
            color: white;
            font-size: 22px;
            cursor: pointer;
        }
        
        /* Imagen en el modal */
        .modal-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 3px solid #0f2453;
        }

        /* --- Sección de Tarjetas --- */
        .seccion-tarjetas {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .seccion-titulo {
            color: #0f2453;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        .tarjetas-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 60px;
        }

        .tarjeta-cabana {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .tarjeta-cabana:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .tarjeta-imagen {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .tarjeta-contenido {
            padding: 20px;
        }

        .tarjeta-titulo {
            color: #0f2453;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .tarjeta-precio {
            color: #e60000;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .tarjeta-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .btn-detalle {
            background: #0f2453;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-detalle:hover {
            background: #132e6b;
            color: white;
            text-decoration: none;
        }

        /* --- Sección de Reservas --- */
        .reservas-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .reserva-item {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .reserva-imagen {
            width: 100px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .reserva-info {
            flex: 1;
        }

        .reserva-cabana {
            font-size: 18px;
            font-weight: 700;
            color: #0f2453;
            margin-bottom: 5px;
        }

        .reserva-fechas {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .reserva-servicios {
            color: #888;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .reserva-total {
            color: #e60000;
            font-weight: 700;
            font-size: 16px;
        }

        .reserva-estado {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .estado-pendiente { background: #fff3cd; color: #856404; }
        .estado-confirmada { background: #d1edff; color: #0c5460; }
        .estado-cancelada { background: #f8d7da; color: #721c24; }

        .sin-reservas {
            text-align: center;
            color: #666;
            padding: 40px;
            font-style: italic;
        }
    </style>
</head>
<body>

<!-- 🔹 Header -->
<nav>
    <div class="container">
        <a href="../index.php" class="brand">Masaya <span style="color:#ffd700;">Glamping</span></a>
        <div>
            <a href="../index.php">Inicio</a>
            <a href="../index.php#about">Acerca de</a>
            <a href="../index.php#gallery">Galería</a>
            <a href="reservar.php">Cabañas</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</nav>

<!-- 🔹 Mapa con íconos -->
<div class="map-container">
    <img src="../images/Mapa-cabanas.jpg" alt="Mapa del Glamping" class="map-image">

    <?php
    // 🔹 Traer todas las cabañas activas para el mapa
    $sqlMapa = "SELECT cod_cabana, nombre, precio_noche, capacidad, caracteristicas, foto 
                FROM cabanas 
                WHERE estado = 'activa'";
    $resMapa = $conn->query($sqlMapa);
    
    $posiciones = [
        ['top'=>'7.5%', 'left'=>'20.5%'],
        ['top'=>'28.7%', 'left'=>'23.5%'],
        ['top'=>'40.5%', 'left'=>'29%'],
        ['top'=>'31.1%', 'left'=>'54.2%'],
        ['top'=>'25.3%', 'left'=>'37.5%'],
    ];
    $i = 0;

    while ($row = $resMapa->fetch_assoc()):
        $coords = $posiciones[$i % count($posiciones)];
        
        // Manejar la imagen
        if (!empty($row['foto'])) {
            $imgSrc = "data:image/jpeg;base64," . base64_encode($row['foto']);
        } else {
            $imgSrc = '../images/default.jpg';
        }
    ?>
        <div class="cabin-marker" style="top:<?= $coords['top'] ?>; left:<?= $coords['left'] ?>;"
             data-id="<?= $row['cod_cabana'] ?>"
             data-nombre="<?= htmlspecialchars($row['nombre']) ?>"
             data-precio="<?= number_format($row['precio_noche'], 0) ?>"
             data-capacidad="<?= htmlspecialchars($row['capacidad']) ?>"
             data-caracteristicas="<?= htmlspecialchars($row['caracteristicas']) ?>"
             data-img="<?= $imgSrc ?>">
            <i class="fa fa-home"></i>
            <div class="tooltip-cabana">
                <h5><?= htmlspecialchars($row['nombre']) ?></h5>
                <p>$<?= number_format($row['precio_noche'], 0) ?> / noche</p>
                <p>Capacidad: <?= $row['capacidad'] ?> personas</p>
            </div>
        </div>
    <?php $i++; endwhile; ?>
</div>

<!-- 🔹 Sección de Tarjetas de Cabañas -->
<div class="seccion-tarjetas">
    <h2 class="seccion-titulo">Nuestras Cabañas</h2>
    <div class="tarjetas-container">
        <?php while ($cabana = $resCabanas->fetch_assoc()): 
            // Manejar la imagen
            if (!empty($cabana['foto'])) {
                $imgCabana = "data:image/jpeg;base64," . base64_encode($cabana['foto']);
            } else {
                $imgCabana = '../images/default.jpg';
            }
        ?>
            <div class="tarjeta-cabana">
                <img src="<?= $imgCabana ?>" alt="<?= htmlspecialchars($cabana['nombre']) ?>" class="tarjeta-imagen">
                <div class="tarjeta-contenido">
                    <h3 class="tarjeta-titulo"><?= htmlspecialchars($cabana['nombre']) ?></h3>
                    <div class="tarjeta-precio">$<?= number_format($cabana['precio_noche'], 2) ?> / noche</div>
                    <div class="tarjeta-info">
                        <strong>Capacidad:</strong> <?= $cabana['capacidad'] ?> personas<br>
                        <strong>Características:</strong> <?= htmlspecialchars($cabana['caracteristicas']) ?>
                    </div>
                    <a href="detalle_cabana.php?id=<?= $cabana['cod_cabana'] ?>" class="btn-detalle">
                        Ver Detalles & Reservar
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- 🔹 Sección de Reservas del Usuario -->
<div class="seccion-tarjetas">
    <h2 class="seccion-titulo">Mis Reservas</h2>
    <div class="reservas-container">
        <?php if ($reservas->num_rows > 0): ?>
            <?php while ($reserva = $reservas->fetch_assoc()): 
                // Manejar la imagen de la cabaña
                if (!empty($reserva['foto_cabana'])) {
                    $imgReserva = "data:image/jpeg;base64," . base64_encode($reserva['foto_cabana']);
                } else {
                    $imgReserva = '../images/default.jpg';
                }
            ?>
                <div class="reserva-item">
                    <img src="<?= $imgReserva ?>" alt="<?= htmlspecialchars($reserva['nombre_cabana']) ?>" class="reserva-imagen">
                    <div class="reserva-info">
                        <div class="reserva-cabana"><?= htmlspecialchars($reserva['nombre_cabana']) ?></div>
                        <div class="reserva-fechas">
                            📅 <?= date('d/m/Y', strtotime($reserva['fecha_inicio'])) ?> 
                            - <?= date('d/m/Y', strtotime($reserva['fecha_fin'])) ?>
                        </div>
                        <div class="reserva-servicios">
                            <strong>Servicios:</strong> <?= nl2br(htmlspecialchars($reserva['servicios_extra'])) ?>
                        </div>
                        <div class="reserva-total">Total: $<?= number_format($reserva['valor_total'], 2) ?></div>
                    </div>
                    <div class="reserva-estado estado-<?= $reserva['estado'] ?>">
                        <?= ucfirst($reserva['estado']) ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="sin-reservas">
                <p>No tienes reservas realizadas.</p>
                <p>¡Explora nuestras cabañas y haz tu primera reserva!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- 🔹 Modal de detalles -->
<div class="modal-cabana" id="modalCabana">
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="modalNombre"></h4>
            <span class="close-btn" onclick="cerrarModal()">&times;</span>
        </div>
        <div class="modal-body">
            <img id="modalImg" src="" alt="" class="modal-img">
            <p><strong>Capacidad:</strong> <span id="modalCapacidad"></span> personas</p>
            <p><strong>Características:</strong> <span id="modalCaract"></span></p>
            <p style="font-weight:700; color:#e60000; font-size: 18px;">$<span id="modalPrecio"></span> / noche</p>
            <a id="modalLink" href="#" class="btn btn-primary" style="background:#0f2453; border:none; border-radius:20px; padding:8px 20px; margin-top: 10px; display: inline-block;">Ver detalle / Reservar</a>
        </div>
    </div>
</div>

<script>
    // Mostrar tooltip al pasar mouse
    document.querySelectorAll('.cabin-marker').forEach(marker => {
        marker.addEventListener('mouseenter', () => {
            marker.querySelector('.tooltip-cabana').style.display = 'block';
        });
        marker.addEventListener('mouseleave', () => {
            marker.querySelector('.tooltip-cabana').style.display = 'none';
        });

        // Abrir modal al hacer clic
        marker.addEventListener('click', () => {
            document.getElementById('modalNombre').innerText = marker.dataset.nombre;
            document.getElementById('modalPrecio').innerText = marker.dataset.precio;
            document.getElementById('modalCapacidad').innerText = marker.dataset.capacidad;
            document.getElementById('modalCaract').innerText = marker.dataset.caracteristicas;
            document.getElementById('modalImg').src = marker.dataset.img;
            document.getElementById('modalLink').href = "detalle_cabana.php?id=" + marker.dataset.id;

            document.getElementById('modalCabana').style.display = 'flex';
        });
    });

    function cerrarModal() {
        document.getElementById('modalCabana').style.display = 'none';
    }

    // Cerrar modal al hacer clic fuera del contenido
    document.getElementById('modalCabana').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });

    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModal();
        }
    });
</script>

</body>
</html>