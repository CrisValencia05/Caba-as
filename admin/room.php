<?php  
session_start();  
if(!isset($_SESSION["user"])) {
    header("location:index.php");
    exit();
}
include('../db.php');

// PROCESAR EDICIÓN
if(isset($_POST['guardar_edicion'])) {
    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $capacidad = intval($_POST['capacidad']);
    $precio = floatval($_POST['precio_noche']);
    $caracteristicas = mysqli_real_escape_string($conn, $_POST['caracteristicas']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);
    
    // Manejar nueva foto si se subió
    if(isset($_FILES['foto_editar']) && $_FILES['foto_editar']['error'] === 0) {
        // Leer el archivo y convertirlo a binario
        $foto = mysqli_real_escape_string($conn, file_get_contents($_FILES['foto_editar']['tmp_name']));
        $sql = "UPDATE Cabanas SET
                    nombre='$nombre',
                    capacidad='$capacidad',
                    precio_noche='$precio',
                    caracteristicas='$caracteristicas',
                    estado='$estado',
                    foto='$foto'
                WHERE cod_cabana='$id'";
    } else {
        // No cambiar la foto, mantener la actual
        $sql = "UPDATE Cabanas SET
                    nombre='$nombre',
                    capacidad='$capacidad',
                    precio_noche='$precio',
                    caracteristicas='$caracteristicas',
                    estado='$estado'
                WHERE cod_cabana='$id'";
    }

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Cabaña actualizada correctamente'); window.location.href='room.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar: ".mysqli_error($conn)."');</script>";
    }
}

// ELIMINAR CABAÑA
if(isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM Cabanas WHERE cod_cabana='$id'");
    echo "<script>alert('Cabaña eliminada'); window.location='room.php';</script>";
}
?> 

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Administrador - Cabañas</title>
<link rel="icon" type="image/png" href="../images/cropped-logo-masaya-experience-2024-32x32.png">
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<link href="assets/css/custom-styles.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<style>
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
                                    <label>Foto:</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*" required>
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
                                
                                // Leer la imagen y convertir a binario
                                $foto = mysqli_real_escape_string($conn, file_get_contents($_FILES['foto']['tmp_name']));

                                $sql = "INSERT INTO Cabanas (cod_glamping, nombre, capacidad, caracteristicas, precio_noche, estado, foto)
                                        VALUES ('$cod_glamping', '$nombre', '$capacidad', '$caracteristicas', '$precio', '$estado', '$foto')";

                                if(mysqli_query($conn, $sql)) {
                                    echo "<script>alert('Cabaña agregada correctamente'); window.location='room.php';</script>";
                                } else {
                                    echo "<script>alert('Error al agregar la cabaña: ".mysqli_error($conn)."');</script>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

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
                                // Mostrar imagen directamente desde la BD
                                $imagenData = $row['foto'];
                                $imagenSrc = "data:image/jpeg;base64," . base64_encode($imagenData);

                                echo "
                                <div class='card-cabana'>
                                    <img src='$imagenSrc' alt='{$row['nombre']}'>
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

        </div>
    </div>
</div>

<!-- MODAL EDITAR CABAÑA -->
<div class="modal fade" id="modalEditarCabana" tabindex="-1" role="dialog" aria-labelledby="editarCabanaLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
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
            <label>Nueva Foto (opcional):</label>
            <input type="file" name="foto_editar" class="form-control" accept="image/*">
            <small class="text-muted">Dejar vacío para mantener la foto actual</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="guardar_edicion" class="btn btn-success">Guardar cambios</button>
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
</body>
</html>