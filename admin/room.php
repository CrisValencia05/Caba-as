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

<!-- Bootstrap Styles-->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FontAwesome Styles-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- Custom Styles-->
<link href="assets/css/custom-styles.css" rel="stylesheet" />
<!-- Google Fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                <div class="col-md-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Agregar Nueva Cabaña</div>
                        <div class="panel-body">
                            <form method="post">
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
                                <input type="submit" name="agregar" value="Agregar Cabaña" class="btn btn-primary">
                            </form>

                            <?php
                            if(isset($_POST['agregar'])) {
                                $cod_glamping = $_POST['cod_glamping'];
                                $nombre = $_POST['nombre'];
                                $capacidad = $_POST['capacidad'];
                                $caracteristicas = $_POST['caracteristicas'];
                                $precio = $_POST['precio_noche'];

                                $sql = "INSERT INTO Cabanas (cod_glamping, nombre, capacidad, caracteristicas, precio_noche)
                                        VALUES ('$cod_glamping', '$nombre', '$capacidad', '$caracteristicas', '$precio')";
                                
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

                <!-- LISTADO DE CABAÑAS -->
                <div class="col-md-7">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Cabañas Registradas</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Glamping</th>
                                            <th>Capacidad</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT Cabanas.cod_cabana, Cabanas.nombre, Glamping.nombre AS glamping, 
                                                         Cabanas.capacidad, Cabanas.precio_noche
                                                  FROM Cabanas
                                                  LEFT JOIN Glamping ON Cabanas.cod_glamping = Glamping.cod_glamping
                                                  ORDER BY Cabanas.cod_cabana DESC";
                                        $res = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($res) > 0) {
                                            while($row = mysqli_fetch_assoc($res)) {
                                                echo "
                                                <tr>
                                                    <td>{$row['cod_cabana']}</td>
                                                    <td>{$row['nombre']}</td>
                                                    <td>{$row['glamping']}</td>
                                                    <td>{$row['capacidad']}</td>
                                                    <td>\${$row['precio_noche']}</td>
                                                    <td>
                                                        <button type='button' class='btn btn-sm btn-info btn-editar'
                                                            data-id='{$row['cod_cabana']}'
                                                            data-nombre='{$row['nombre']}'
                                                            data-capacidad='{$row['capacidad']}'
                                                            data-precio='{$row['precio_noche']}'>
                                                            Editar
                                                        </button>
                                                    </td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No hay cabañas registradas</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- page-inner -->
    </div> <!-- page-wrapper -->
</div> <!-- wrapper -->

<!-- MODAL EDITAR CABAÑA -->
<div class="modal fade" id="modalEditarCabana" tabindex="-1" role="dialog" aria-labelledby="editarCabanaLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" action="editar_cabana.php">
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
        </div>
        <div class="modal-footer">
          <button type="submit" name="guardar" class="btn btn-success">Guardar cambios</button>
          <a id="btnEliminarCabana" href="#" class="btn btn-danger">Eliminar</a>
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
    // Abrir modal y cargar datos
    $('.btn-editar').click(function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const capacidad = $(this).data('capacidad');
        const precio = $(this).data('precio');

        $('#edit-id').val(id);
        $('#edit-nombre').val(nombre);
        $('#edit-capacidad').val(capacidad);
        $('#edit-precio').val(precio);

        // Actualizar enlace eliminar
        $('#btnEliminarCabana').attr('href', 'room.php?eliminar=' + id);

        $('#modalEditarCabana').modal('show');
    });

    // Eliminar desde modal
    $('#btnEliminarCabana').click(function(e){
        if(!confirm('¿Seguro que deseas eliminar esta cabaña?')) {
            e.preventDefault();
        }
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