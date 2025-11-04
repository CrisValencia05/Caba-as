<?php  
session_start();  
if (!isset($_SESSION["user"])) {
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
    <title>Administrador - Usuarios</title>
    <link rel="icon" type="image/png" href="../images/cropped-logo-masaya-experience-2024-32x32.png">
    <!-- Bootstrap Styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles -->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- DataTables Styles -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="wrapper">
    <!-- NAV TOP -->
    <nav class="navbar navbar-default top-navbar" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="home.php"><?php echo $_SESSION["user"]; ?></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="../index.php" class="btn btn-danger" style="margin-top:8px; color:white;">
                    <i class="fa fa-sign-out fa-fw"></i> Cerrar sesión
                </a>
            </li>
        </ul>
    </nav>

    <!-- NAV SIDE -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Reservas</a></li>
                <li><a class="active-menu" href="vista_usuarios.php"><i class="fa fa-desktop"></i> Usuarios</a></li>
                <li><a href="vista_empleados.php"><i class="fa fa-qrcode"></i> Empleados</a></li>
                <li><a href="room.php"><i class="fa fa-plus-circle"></i> Cabañas</a></li>
            </ul>
        </div>
    </nav>

   <!-- PAGE WRAPPER -->
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Lista de Clientes <small>panel</small></h1>
            </div>
        </div>

        <!-- Tabla de Clientes -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lista de Clientes Registrados
                    </div>
                    <div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Segundo Nombre</th>
                    <th>Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Celular</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT cod_cliente, nombre, segundo_nombre, apellido, segundo_apellido, celular, direccion, correo, fecha_registro 
                        FROM Usuarios 
                        ORDER BY cod_cliente DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['cod_cliente']); ?></td>
                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                            <td><?= htmlspecialchars($row['segundo_nombre']); ?></td>
                            <td><?= htmlspecialchars($row['apellido']); ?></td>
                            <td><?= htmlspecialchars($row['segundo_apellido']); ?></td>
                            <td><?= htmlspecialchars($row['celular']); ?></td>
                            <td><?= htmlspecialchars($row['direccion']); ?></td>
                            <td><?= htmlspecialchars($row['correo']); ?></td>
                            <td><?= htmlspecialchars($row['fecha_registro']); ?></td>
                            <td>
                                <button 
                                    type="button"
                                    class="btn btn-sm btn-primary editarBtn" 
                                    data-id="<?= $row['cod_cliente']; ?>"
                                    data-nombre="<?= htmlspecialchars($row['nombre']); ?>"
                                    data-segundo_nombre="<?= htmlspecialchars($row['segundo_nombre']); ?>"
                                    data-apellido="<?= htmlspecialchars($row['apellido']); ?>"
                                    data-segundo_apellido="<?= htmlspecialchars($row['segundo_apellido']); ?>"
                                    data-celular="<?= htmlspecialchars($row['celular']); ?>"
                                    data-direccion="<?= htmlspecialchars($row['direccion']); ?>"
                                    data-correo="<?= htmlspecialchars($row['correo']); ?>">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='10' class='text-center'>No hay clientes registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR USUARIO -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditar" method="POST">
        <div class="modal-header">
          <h4 class="modal-title" id="editarLabel">Editar Usuario</h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="cod_cliente" id="editId">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="editNombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Segundo Nombre</label>
                <input type="text" name="segundo_nombre" id="editSegundoNombre" class="form-control">
            </div>
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" name="apellido" id="editApellido" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Segundo Apellido</label>
                <input type="text" name="segundo_apellido" id="editSegundoApellido" class="form-control">
            </div>
            <div class="form-group">
                <label>Celular</label>
                <input type="text" name="celular" id="editCelular" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" id="editDireccion" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" id="editCorreo" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="guardarCambios" class="btn btn-success">Guardar Cambios</button>
          <button type="submit" name="eliminar" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
// GUARDAR CAMBIOS
if (isset($_POST['guardarCambios'])) {
    $id = $_POST['cod_cliente'];
    $nombre = $_POST['nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $apellido = $_POST['apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];

    $update = "UPDATE Usuarios SET 
                nombre='$nombre',
                segundo_nombre='$segundo_nombre',
                apellido='$apellido',
                segundo_apellido='$segundo_apellido',
                celular='$celular',
                direccion='$direccion',
                correo='$correo'
               WHERE cod_cliente='$id'";
    mysqli_query($conn, $update);
    echo "<script>alert('Usuario actualizado correctamente'); window.location='vista_usuarios.php';</script>";
}

// ELIMINAR USUARIO
if (isset($_POST['eliminar'])) {
    $id = $_POST['cod_cliente'];
    mysqli_query($conn, "DELETE FROM Usuarios WHERE cod_cliente='$id'");
    echo "<script>alert('Usuario eliminado correctamente'); window.location='vista_usuarios.php';</script>";
}
?>

<!-- JS Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
$(document).ready(function () {
    $('#dataTables-example').DataTable();

    // Rellenar el modal con los datos del usuario seleccionado
    $('.editarBtn').on('click', function() {
        $('#editId').val($(this).data('id'));
        $('#editNombre').val($(this).data('nombre'));
        $('#editSegundoNombre').val($(this).data('segundo_nombre'));
        $('#editApellido').val($(this).data('apellido'));
        $('#editSegundoApellido').val($(this).data('segundo_apellido'));
        $('#editCelular').val($(this).data('celular'));
        $('#editDireccion').val($(this).data('direccion'));
        $('#editCorreo').val($(this).data('correo'));
        $('#editarModal').modal('show');
    });
});
</script>
<script src="assets/js/custom-scripts.js"></script>
</body>
</html>