<?php  
session_start();  
if(!isset($_SESSION["user"])) {
    header("location:index.php");
    exit();
}
include('../db.php');
?> 

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>HOTEL Amanecer - Cabañas</title>
<link rel="icon" type="image/png" href="../images/cropped-logo-masaya-experience-2024-32x32.png">
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<link href="assets/css/custom-styles.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<style>
/* Estilos para las tarjetas */
.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.card-cabana {
    width: calc(25% - 20px);
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
    background: #fff;
    display: flex;
    flex-direction: column;
}
.card-cabana img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}
.card-body {
    padding: 10px;
    flex: 1;
}
.card-body h4 {
    margin: 0 0 5px 0;
}
.card-body p {
    font-size: 14px;
    margin: 2px 0;
}
.card-actions {
    display: flex;
    justify-content: space-between;
    padding: 5px 10px 10px;
}
</style>
</head>

<body>
<div id="wrapper">
    <!-- NAVBAR SUPERIOR -->
    <nav class="navbar navbar-default top-navbar" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="home.php">ADMIN</a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li><a href="../index.php" class="btn btn-danger" style="margin-top:8px; color:white;">
            <i class="fa fa-sign-out fa-fw"></i> Cerrar sesión
            </a></li>
        </ul>
    </nav>

    <!-- MENU LATERAL -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Reservas</a></li>
                <li><a href="vista_usuarios.php"><i class="fa fa-users"></i> Usuarios</a></li>
                <li><a href="vista_empleados.php"><i class="fa fa-qrcode"></i> Empleados</a></li>
                <li><a class="active-menu" href="room.php"><i class="fa fa-plus-circle"></i> Cabañas</a></li>
            </ul>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Gestión de Cabañas</h1>
                </div>
            </div>

            <div class="row">
                <!-- FORMULARIO PARA AGREGAR CABAÑA -->
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Agregar Nueva Cabaña</div>
                        <div class="panel-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Glamping asociado:</label>
                                    <select name="cod_glamping" class="form-control" required>
                                        <option value="">Seleccione un glamping</option>
                                        <?php
                                        $glampings = mysqli_query($conn, "SELECT cod_glamping, nombre FROM Glamping");
                                        while($g = mysqli_fetch_assoc($glampings)) {
                                            echo "<option value='{$g['cod_glamping']}'>{$g['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nombre de la cabaña:</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Capacidad (personas):</label>
                                    <input type="number" name="capacidad" class="form-control" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label>Características:</label>
                                    <textarea name="caracteristicas" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Precio por noche:</label>
                                    <input type="number" name="precio_noche" class="form-control" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label>Estado:</label>
                                    <select name="estado" class="form-control" required>
                                        <option value="activa">Activa</option>
                                        <option value="mantenimiento">Mantenimiento</option>
                                        <option value="inactiva">Inactiva</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Fotos (máx 4):</label>
                                    <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple required>
                                </div>
                                <input type="submit" name="agregar" value="Agregar Cabaña" class="btn btn-primary">
                            </form>

                            <?php
                            if(isset($_POST['agregar'])) {
                                $cod_glamping = $_POST['cod_glamping'];
                                $nombre = $_POST['nombre'];
                                $capacidad = $_POST['capacidad'];
                                $caracteristicas = $_POST['caracteristicas'];
                                $precio = $_POST['precio_noche'];
                                $estado = $_POST['estado'];

                                // Manejar fotos
                                $fotos = ['foto1'=>null,'foto2'=>null,'foto3'=>null,'foto4'=>null];
                                if(isset($_FILES['fotos'])) {
                                    $uploadDir = '../images/'; // esta es la carpeta real donde se guardan
                                    $relativeDir = '../images/';  // esta es la ruta que se guardará en la BD
                                    foreach($_FILES['fotos']['tmp_name'] as $key => $tmpName){
                                        foreach($_FILES['fotos']['tmp_name'] as $key => $tmpName){
                                            if($_FILES['fotos']['error'][$key] === 0 && $key < 4){
                                                $fileName = uniqid() . '_' . basename($_FILES['fotos']['name'][$key]);
                                                move_uploaded_file($tmpName, $uploadDir . $fileName);
                                                $fotos['foto'.($key+1)] = $relativeDir . $fileName;
                                             }
                                        }
                                    }
                                }

                                $sql = "INSERT INTO Cabanas (cod_glamping, nombre, capacidad, caracteristicas, precio_noche, estado, foto1, foto2, foto3, foto4)
                                        VALUES ('$cod_glamping', '$nombre', '$capacidad', '$caracteristicas', '$precio', '$estado',
                                        '{$fotos['foto1']}', '{$fotos['foto2']}', '{$fotos['foto3']}', '{$fotos['foto4']}')";

                                if(mysqli_query($conn, $sql)) {
                                    echo "<script>alert('Cabaña agregada correctamente'); window.location='room.php';</script>";
                                } else {
                                    echo "<script>alert('Error al agregar la cabaña');</script>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->

            <!-- TARJETAS DE CABAÑAS -->
            <div class="row">
                <div class="col-md-12">
                    <h3>Cabañas Registradas</h3>
                    <br>
                    <div class="card-container">
                        <?php
                        $query = "SELECT Cabanas.*, Glamping.nombre AS glamping
                                  FROM Cabanas
                                  LEFT JOIN Glamping ON Cabanas.cod_glamping = Glamping.cod_glamping
                                  ORDER BY Cabanas.cod_cabana DESC";
                        $res = mysqli_query($conn, $query);

                        if(mysqli_num_rows($res) > 0) {
                            while($row = mysqli_fetch_assoc($res)) {
                                $imgPath = '../' . $row['foto1']; // sube un nivel desde /admin/
                                    if (!file_exists($imgPath)) {
                                        $imgPath = '../images/default.jpg';
                                    }
                                echo"
                                <div class='card-cabana'>
                                    <img src='{images/}' alt='{$row['foto1']}'>
                                    <div class='card-body'>
                                        <h4>{$row['nombre']}</h4>
                                        <p><strong>Glamping:</strong> {$row['glamping']}</p>
                                        <p><strong>Capacidad:</strong> {$row['capacidad']} personas</p>
                                        <p><strong>Precio:</strong> \${$row['precio_noche']}</p>
                                        <p><strong>Estado:</strong> {$row['estado']}</p>
                                    </div>
                                    <div class='card-actions'>
                                        <button class='btn btn-sm btn-info btn-editar'
                                            data-id='{$row['cod_cabana']}'
                                            data-nombre='{$row['nombre']}'
                                            data-capacidad='{$row['capacidad']}'
                                            data-precio='{$row['precio_noche']}'
                                            data-caracteristicas='".htmlspecialchars($row['caracteristicas'], ENT_QUOTES)."'
                                            data-estado='{$row['estado']}'>
                                            Editar
                                        </button>
                                        <a href='room.php?eliminar={$row['cod_cabana']}' class='btn btn-sm btn-danger' onclick='return confirm(\"¿Deseas eliminar esta cabaña?\")'>Eliminar</a>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<p>No hay cabañas registradas</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div> <!-- page-inner -->
    </div> <!-- page-wrapper -->
</div> <!-- wrapper -->

<!-- MODAL EDITAR CABAÑA -->
<div class="modal fade" id="modalEditarCabana" tabindex="-1" role="dialog" aria-labelledby="editarCabanaLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" action="editar_cabana.php" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="editarCabanaLabel">Editar Cabaña</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Capacidad:</label>
            <input type="number" name="capacidad" id="edit-capacidad" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Precio por noche:</label>
            <input type="number" name="precio_noche" id="edit-precio" class="form-control" step="0.01" required>
          </div>
          <div class="form-group">
            <label>Características:</label>
            <textarea name="caracteristicas" id="edit-caracteristicas" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>Estado:</label>
            <select name="estado" id="edit-estado" class="form-control">
                <option value="activa">Activa</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="inactiva">Inactiva</option>
            </select>
          </div>
          <div class="form-group">
            <label>Fotos (puedes reemplazar):</label>
            <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="guardar" class="btn btn-success">Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script>
$(document).ready(function() {
    $('.btn-editar').click(function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const capacidad = $(this).data('capacidad');
        const precio = $(this).data('precio');
        const caracteristicas = $(this).data('caracteristicas');
        const estado = $(this).data('estado');

        $('#edit-id').val(id);
        $('#edit-nombre').val(nombre);
        $('#edit-capacidad').val(capacidad);
        $('#edit-precio').val(precio);
        $('#edit-caracteristicas').val(caracteristicas);
        $('#edit-estado').val(estado);

        $('#modalEditarCabana').modal('show');
    });
});
</script>

<?php
// ELIMINAR CABAÑA
if(isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM Cabanas WHERE cod_cabana='$id'");
    echo "<script>alert('Cabaña eliminada'); window.location='room.php';</script>";
}
?>
</body>
</html>