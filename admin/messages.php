<?php  
session_start();  
if (!isset($_SESSION["user"])) {
    header("location:index.php");
    exit();
}
include('db.php');
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hotel Amanecer</title>
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
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Navegación de palanca</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php"><?php echo $_SESSION["user"]; ?></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> Perfil del usuario</a></li>
                    <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Configuraciones</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- NAV SIDE -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li><a href="home.php"><i class="fa fa-dashboard"></i> Estado</a></li>
                <li><a class="active-menu" href="messages.php"><i class="fa fa-desktop"></i> Mensajes Masivos</a></li>
                <li><a href="roombook.php"><i class="fa fa-bar-chart-o"></i> Reserva de habitación</a></li>
                <li><a href="Payment.php"><i class="fa fa-qrcode"></i> Pago</a></li>
                <li><a href="profit.php"><i class="fa fa-qrcode"></i> Lucro</a></li>
                <li><a href="settings.php"><i class="fa fa-dashboard"></i> Estado de la habitación</a></li>
                <li><a href="room.php"><i class="fa fa-plus-circle"></i> Agregar habitación</a></li>
                <li><a href="roomdel.php"><i class="fa fa-pencil-square-o"></i> Eliminar habitación</a></li>
            </ul>
        </div>
    </nav>

    <!-- PAGE WRAPPER -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Mensajes Masivos <small>panel</small></h1>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron">
                        <h3>Enviar boletines de noticias a los seguidores</h3>
                        <p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Enviar nuevo boletín</button>
                        </p>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="post">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Redactar Boletín</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Título</label>
                                                <input name="title" class="form-control" placeholder="Ingrese el título" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tema</label>
                                                <input name="subject" class="form-control" placeholder="Ingrese el tema" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Noticias</label>
                                                <textarea name="news" class="form-control" rows="5" placeholder="Ingrese las noticias" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <input type="submit" name="log" value="Enviar" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['log'])) {
                            $title = mysqli_real_escape_string($conn, $_POST['title']);
                            $subject = mysqli_real_escape_string($conn, $_POST['subject']);
                            $news = mysqli_real_escape_string($conn, $_POST['news']);

                            $log = "INSERT INTO `newsletterlog`(`title`, `subject`, `news`) VALUES ('$title','$subject','$news')";
                            if (mysqli_query($conn, $log)) {
                                echo '<script>alert("Boletín enviado correctamente.")</script>';
                            } else {
                                echo '<script>alert("Error al enviar el boletín.")</script>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Subscribers Table -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">Lista de Seguidores</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Aprobación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `contact`";
                                        $re = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_array($re)) {
                                            // Asegúrate de que la variable $id está bien definida y se escapa correctamente
                                            $id = htmlspecialchars($row['id']); // Protección contra XSS
                                            
                                            // Imprimir la fila de la tabla
                                            echo "<tr class='" . (($row['id'] % 2 == 1) ? "gradeC" : "gradeU") . "'>
                                                    <td>" . htmlspecialchars($row['fullname']) . "</td>   <!-- Evitar XSS -->
                                                    <td>" . htmlspecialchars($row['phoneno']) . "</td>    <!-- Evitar XSS -->
                                                    <td>" . htmlspecialchars($row['email']) . "</td>      <!-- Evitar XSS -->
                                                    <td>" . htmlspecialchars($row['cdate']) . "</td>      <!-- Evitar XSS -->
                                                    <td>" . htmlspecialchars($row['approval']) . "</td>   <!-- Evitar XSS -->
                                                    <td>
                                                        <!-- Enlace para permiso -->
                                                        <a href='newsletter.php?eid=$id' class='btn btn-primary btn-sm'>
                                                            <i class='fa fa-edit'></i> Permiso
                                                        </a>
                                                        <!-- Enlace para eliminar -->
                                                        <a href='newsletterdel.php?eid=$id' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Está seguro de eliminar este seguidor?');\">
                                                            <i class='fa fa-trash'></i> Eliminar
                                                        </a>
                                                    </td>
                                                  </tr>";
                                        }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Advanced Tables -->
                </div>
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
    });
</script>
<script src="assets/js/custom-scripts.js"></script>
</body>
</html>
