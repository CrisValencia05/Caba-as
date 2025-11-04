<?php  
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}

include ('../db.php');
?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrador - Reservas</title>
    <link rel="icon" type="image/png" href="../images/cropped-logo-masaya-experience-2024-32x32.png">
    
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Navegación de palanca
</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"> <?php echo $_SESSION["user"]; ?> </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
    <li>
        <a href="../index.php" class="btn btn-danger" style="margin-top:8px; color:white;">
            <i class="fa fa-sign-out fa-fw"></i> Cerrar sesión
        </a>
    </li>
    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="home.php"><i class="fa fa-dashboard"></i> Reservas</a>
                    </li>
                    <li>
                        <a href="vista_usuarios.php"><i class="fa fa-desktop"></i> Usuarios
</a>
                    </li>
                    <li>
                        <a href="vista_empleados.php"><i class="fa fa-qrcode"></i> Empleados</a>
                    </li>
					<li>
                        <a  href="room.php"><i class="fa fa-plus-circle"></i> Cabañas</a>
                    </li>
                    


                    
					</ul>

            </div>

        </nav>
     

<div id="page-wrapper">
  <div id="page-inner">

    <div class="row">
      <div class="col-md-12">
        <h1 class="page-header">
          Reservaciones <small>Lista de todas las reservas</small>
        </h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4>Listado de Reservas</h4>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Nombre Cliente</th>
                    <th>Cabaña</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de fin</th>
                    <th>Fecha de registro</th>
                    <th>Servicios extra</th>
                    <th>Valor total</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Consultamos todas las reservas con el nombre del cliente y la cabaña
                  $sql = "SELECT 
                            r.cod_reserva, 
                            CONCAT(u.nombre, ' ', u.apellido) AS cliente, 
                            c.nombre AS cabana,
                            r.fecha_inicio,
                            r.fecha_fin,
                            r.fecha_registro,
                            r.servicios_extra,
                            r.valor_total
                          FROM reservas r
                          LEFT JOIN usuarios u ON r.cod_cliente = u.cod_cliente
                          LEFT JOIN cabanas c ON r.cod_cabana = c.cod_cabana
                          ORDER BY r.cod_reserva DESC";
                  
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>
                              <td>{$row['cod_reserva']}</td>
                              <td>{$row['cliente']}</td>
                              <td>{$row['cabana']}</td>
                              <td>{$row['fecha_inicio']}</td>
                              <td>{$row['fecha_fin']}</td>
                              <td>{$row['fecha_registro']}</td>
                              <td>{$row['servicios_extra']}</td>
                              <td>$" . number_format($row['valor_total'], 0, ',', '.') . "</td>
                              <td>
                                <a href='home.php?eliminar={$row['cod_reserva']}' 
                                    class='btn btn-danger btn-sm' 
                                    onclick='return confirmarEliminacion()'>
                                    Eliminar
                                </a>
                              </td>
                            </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='9' class='text-center'>No hay reservas registradas</td></tr>";
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

<script>
  function confirmarEliminacion() {
    return confirm("¿Estás seguro de que deseas eliminar esta reserva?");
  }
</script>

<?php
// --- Eliminar reserva ---
if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  $delete = "DELETE FROM reservas WHERE cod_reserva = $id";
  if (mysqli_query($conn, $delete)) {
    echo "<script>
            alert('Reserva eliminada correctamente');
            window.location.href='home.php';
          </script>";
  } else {
    echo "<script>alert('Error al eliminar la reserva');</script>";
  }
}
?>

                <!-- /. ROW  -->
				
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>