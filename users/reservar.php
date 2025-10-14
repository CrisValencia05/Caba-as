```php
<?php
session_start();
include('../db.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Habitaciones y Tarifas - New Dawn Glamping</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
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
            top: 0;
            left: 0;
            right: 0;
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
        .container-principal {
            max-width: 1300px;
            margin: 100px auto 60px auto;
            padding: 0 20px;
        }

        h2.title {
            color: #0f2453;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
        }

        /* --- Grilla de tarjetas --- */
        .grid-cabanas {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            justify-items: center;
        }

        .card-cabana {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease-in-out;
            width: 100%;
            max-width: 300px;
        }

        .card-cabana:hover {
            transform: translateY(-6px);
        }

        .card-cabana img {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .card-cabana h4 {
            background: #0f2453;
            color: #fff;
            font-weight: 700;
            font-size: 18px;
            padding: 10px 15px;
            margin: 0;
        }

        .card-body {
            padding: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .meta-stars i {
            color: #f0c419;
            margin-right: 3px;
        }

        .precio {
            font-size: 18px;
            font-weight: 700;
            color: #e60000;
        }

        .btn-ver {
            background: #0f2453;
            color: #fff;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-ver:hover {
            background: #132e6b;
        }
    </style>
</head>

<body>
    <!-- 🔹 Barra superior -->
    <nav>
        <div class="container">
            <a href="../index.php" class="brand">NEW <span style="color:#ffd700;">DAWN</span></a>
            <div>
                <a href="../index.php">Inicio</a>
                <a href="../index.php#about">Acerca de</a>
                <a href="../index.php#gallery">Galería</a>
                <a href="reservar.php">Cabañas</a>
                <?php if (isset($_SESSION['cod_cliente'])): ?>
                    <a href="logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a href="login.php">Usuarios</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 🔹 Contenido principal -->
    <div class="container-principal">
        <h2 class="title">Habitaciones Y Tarifas</h2>
        <div class="grid-cabanas">
            <?php
            // Traer todas las cabañas desde la base de datos
            $sql = "SELECT cod_cabana, nombre, caracteristicas, precio_noche FROM cabanas ORDER BY cod_cabana ASC";
            $res = $conn->query($sql);

            $cabanas = [];
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $cabanas[] = $row;
                }
            } else {
                // Si la BD está vacía, se cargan ejemplos
                $cabanas = [
                    ["cod_cabana" => 1, "nombre" => "Cabaña Deluxe", "caracteristicas" => "Jacuzzi y vista a la montaña", "precio_noche" => 320],
                    ["cod_cabana" => 2, "nombre" => "Cabaña Familiar", "caracteristicas" => "Espaciosa con terraza", "precio_noche" => 250],
                    ["cod_cabana" => 3, "nombre" => "Cabaña Bosque", "caracteristicas" => "Vista panorámica al bosque", "precio_noche" => 180],
                    ["cod_cabana" => 4, "nombre" => "Cabaña Romántica", "caracteristicas" => "Decoración especial para parejas", "precio_noche" => 300],
                    ["cod_cabana" => 5, "nombre" => "Cabaña EcoVista", "caracteristicas" => "Diseño ecológico con energía solar", "precio_noche" => 290],
                    ["cod_cabana" => 6, "nombre" => "Cabaña Relax", "caracteristicas" => "Ideal para descansar en la naturaleza", "precio_noche" => 270],
                    ["cod_cabana" => 7, "nombre" => "Cabaña Amanecer", "caracteristicas" => "Perfecta para ver el amanecer", "precio_noche" => 310],
                    ["cod_cabana" => 8, "nombre" => "Cabaña Premium", "caracteristicas" => "Comodidad y lujo máximo", "precio_noche" => 350]
                ];
            }

            // Mostrar las cabañas
            foreach ($cabanas as $row):
                $imgNum = $row['cod_cabana'] % 4 ?: 4;
                $img = "../images/r{$imgNum}.jpg";

                if (isset($_SESSION['cod_cliente'])) {
                    $link = "detalle_cabana.php?id=" . $row['cod_cabana'];
                } else {
                    $link = "login.php?redirect=" . urlencode("detalle_cabana.php?id=" . $row['cod_cabana']);
                }
            ?>
                <div class="card-cabana">
                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                    <h4><?php echo htmlspecialchars($row['nombre']); ?></h4>
                    <div class="card-body">
                        <div>
                            <div class="meta-stars">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                <i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>
                            </div>
                            <p style="color:#333; margin-bottom:10px;"><?php echo htmlspecialchars($row['caracteristicas']); ?></p>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="precio">$ <?php echo number_format($row['precio_noche'], 2); ?></div>
                            <a href="<?php echo $link; ?>" class="btn-ver">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
```
