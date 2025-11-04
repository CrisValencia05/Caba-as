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
    <title>Administrador - Empleados</title>
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
                <li><a href="vista_usuarios.php"><i class="fa fa-users"></i> Usuarios</a></li>
                <li><a class="active-menu" href="vista_empleados.php"><i class="fa fa-qrcode"></i> Empleados</a></li>
                <li><a href="room.php"><i class="fa fa-plus-circle"></i> Cabañas</a></li>
            </ul>
        </div>
    </nav>

    <!-- PAGE WRAPPER -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Lista de Empleados <small>panel</small></h1>
                </div>
            </div>

            <!-- Tabla de Empleados -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Empleados Registrados
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
                                            <th>Cargo</th>
                                            <th>Salario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT e.cod_empleado, e.nombre, e.segundo_nombre, e.apellido, e.segundo_apellido, 
                                                        e.celular, e.direccion, e.correo, 
                                                        c.nombre AS cargo, c.salario
                                                FROM Empleado e
                                                LEFT JOIN CargoEmpleado c ON e.cod_cargo = c.cod_cargo
                                                ORDER BY e.cod_empleado DESC";
                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $id = htmlspecialchars($row['cod_empleado']);
                                                echo "<tr>
                                                    <td>{$id}</td>
                                                    <td>" . htmlspecialchars($row['nombre']) . "</td>
                                                    <td>" . htmlspecialchars($row['segundo_nombre'] ?? '-') . "</td>
                                                    <td>" . htmlspecialchars($row['apellido']) . "</td>
                                                    <td>" . htmlspecialchars($row['segundo_apellido'] ?? '-') . "</td>
                                                    <td>" . htmlspecialchars($row['celular'] ?? '-') . "</td>
                                                    <td>" . htmlspecialchars($row['direccion'] ?? '-') . "</td>
                                                    <td>" . htmlspecialchars($row['correo'] ?? '-') . "</td>
                                                    <td>" . htmlspecialchars($row['cargo'] ?? 'Sin cargo') . "</td>
                                                    <td>" . htmlspecialchars($row['salario'] ?? 'No definido') . "</td>
                                                    <td>
                                                        <button class='btn btn-sm btn-primary edit-btn' 
                                                            data-id='{$id}'
                                                            data-nombre='" . htmlspecialchars($row['nombre']) . "'
                                                            data-segundonombre='" . htmlspecialchars($row['segundo_nombre']) . "'
                                                            data-apellido='" . htmlspecialchars($row['apellido']) . "'
                                                            data-segundoapellido='" . htmlspecialchars($row['segundo_apellido']) . "'
                                                            data-celular='" . htmlspecialchars($row['celular']) . "'
                                                            data-direccion='" . htmlspecialchars($row['direccion']) . "'
                                                            data-correo='" . htmlspecialchars($row['correo']) . "'
                                                            data-cargo='" . htmlspecialchars($row['cargo']) . "'
                                                            data-salario='" . htmlspecialchars($row['salario']) . "'>
                                                            <i class='fa fa-edit'></i> Editar
                                                        </button>
                                                    </td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='11' class='text-center'>No hay empleados registrados</td></tr>";
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

    <!-- MODAL EDITAR EMPLEADO -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editForm" method="POST" action="editar_empleado.php">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editModalLabel">Editar Empleado</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">

                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Segundo Nombre</label>
                            <input type="text" class="form-control" id="editSegundoNombre" name="segundo_nombre">
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" class="form-control" id="editApellido" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label>Segundo Apellido</label>
                            <input type="text" class="form-control" id="editSegundoApellido" name="segundo_apellido">
                        </div>
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="text" class="form-control" id="editCelular" name="celular">
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" id="editDireccion" name="direccion">
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="email" class="form-control" id="editCorreo" name="correo">
                        </div>
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" class="form-control" id="editCargo" name="cargo">
                        </div>
                        <div class="form-group">
                            <label>Salario</label>
                            <input type="number" class="form-control" id="editSalario" name="salario">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                        <button type="button" class="btn btn-danger" id="deleteBtn">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- JS Scripts -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
$(document).ready(function () {
    $('#dataTables-example').DataTable();

    // Abrir modal con datos del empleado
    $('.edit-btn').click(function () {
        $('#editId').val($(this).data('id'));
        $('#editNombre').val($(this).data('nombre'));
        $('#editSegundoNombre').val($(this).data('segundonombre'));
        $('#editApellido').val($(this).data('apellido'));
        $('#editSegundoApellido').val($(this).data('segundoapellido'));
        $('#editCelular').val($(this).data('celular'));
        $('#editDireccion').val($(this).data('direccion'));
        $('#editCorreo').val($(this).data('correo'));
        $('#editCargo').val($(this).data('cargo'));
        $('#editSalario').val($(this).data('salario'));
        $('#editModal').modal('show');
    });

    // Eliminar empleado
    $('#deleteBtn').click(function () {
        if (confirm('¿Seguro que deseas eliminar este empleado?')) {
            const id = $('#editId').val();
            window.location.href = 'eliminar_empleado.php?id=' + id;
        }
    });
});
</script>
<script src="assets/js/custom-scripts.js"></script>
</body>
</html>