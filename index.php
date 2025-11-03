<?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Masaya San Agustin - Glamping</title>
	<link rel="icon" type="image/png" href="images/cropped-logo-masaya-experience-2024-32x32.png">
	<!-- for-mobile-apps -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Resort Inn Responsive , Smartphone Compatible web template , Samsung, LG, Sony Ericsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //for-mobile-apps -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/chocolat.css" type="text/css" media="screen">
	<link href="css/easy-responsive-tabs.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" property="" />
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<script type="text/javascript" src="js/modernizr-2.6.2.min.js"></script>
	<!--fonts-->
	<link href="//fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Federo" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
	<!--//fonts-->

	<style>
        /* Estilos adicionales para el botón flotante de WhatsApp */
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #25d366;
            color: #fff;
            padding: 20px;
            border-radius: 50%;
            text-align: center;
            font-size: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

</head>

<body>
	<div class="w3_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Palanca de navegacion</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<h1><a class="navbar-brand" href="index.php"> Masaya <span>Glamping</span>
							<p class="logo_w3l_agile_caption">SAN AGUSTIN</p>
						</a></h1>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav class="menu menu--iris">
						<ul class="nav navbar-nav menu__list">
							<li class="menu__item"><a href="#about" class="menu__link scroll">Acerca de</a></li>
							<li class="menu__item"><a href="#gallery" class="menu__link scroll">Galería</a></li>
							<li class="menu__item"><a href="#rooms" class="menu__link scroll">Cabañas</a></li>
							<li><a href="users/login.php">Usuarios</a></li>
							<li class="menu__item"><a href="#contact" class="menu__link scroll">Contáctenos</a></li>
							<li><a href="login.php">admin</a></li>

						</ul>
					</nav>
				</div>
			</nav>

		</div>
	</div>
	<!-- //header -->
	<!-- banner -->
	<div id="home" class="w3ls-banner">
		<!-- banner-text -->
		<div class="slider">
			<div class="callbacks_container">
				<ul class="rslides callbacks callbacks1" id="slider4">
					<li>
						<div class="w3layouts-banner-top">

							<div class="container">
								<div class="agileits-banner-info">
									<h4>Bienvenido a Masaya</h4>
									<h3>Vive experiencias únicas </h3>
									<p>Disfruta de paisajes espectaculares.
									</p>
									<div class="agileits_w3layouts_more menu__item">
										<a href="#" class="menu__link" data-toggle="modal" data-target="#myModal">leer más
										</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="w3layouts-banner-top w3layouts-banner-top1">
							<div class="container">
								<div class="agileits-banner-info">
									<h4>Tu refugio</h4>
									<h3>Disfruta de momentos inolvidables en Masaya</h3>
									<p>Reserva ahora</p>
									<div class="agileits_w3layouts_more menu__item">
										<a href="#" class="menu__link" data-toggle="modal" data-target="#myModal">leer más</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="w3layouts-banner-top w3layouts-banner-top2">
							<div class="container">
								<div class="agileits-banner-info">
									<h4>Vive el lujo</h4>
									<h3>Momentos que recordarás para siempre</h3>
									<p>Conoce nuestras cabañas</p>
									<div class="agileits_w3layouts_more menu__item">
										<a href="#" class="menu__link" data-toggle="modal" data-target="#myModal">leer más</a>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div>
			<!--banner Slider starts Here-->
		</div>
		<div class="thim-click-to-bottom">
			<a href="#about" class="scroll">
				<i class="fa fa-long-arrow-down" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<!-- //banner -->
	<!--//Header-->
	<!-- //Modal1 -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		<!-- Modal1 -->
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4>Masaya <span>Glamping</span></h4>
					<img src="images/190576909.jpg" alt=" " class="img-responsive">
					<h5>Sabemos lo que amas</h5>
					<p>Ofrecer a los huéspedes vistas únicas y encantadoras desde sus Cabañas con sus comodidades excepcionales, hace que Masaya sea uno de los mejores en su tipo. Pruebe nuestro menú de comida, servicios increíbles y un personal amable mientras esté aquí..</p>
				</div>
			</div>
		</div>
	</div>
	<!-- //Modal1 -->
	<div id="availability-agileits">
		<div class="col-md-12 book-form-left-w3layouts">
			<a href="users/login.php">
				<h2>RESERVA TU MEJOR EXPERIENCIA
				</h2>
			</a>
		</div>

		<div class="clearfix"> </div>
	</div>
	<!-- banner-bottom -->
	<div class="banner-bottom">
		<div class="container">
			<div class="agileits_banner_bottom">
				<h3><span>Cada estancia incluye comodidades excepcionales, un menú delicioso y un servicio amable que hará que tu experiencia sea inolvidable.</span> Encuentra nuestra acogedora bienvenida
				</h3>
			</div>
			<div class="w3ls_banner_bottom_grids">
				<ul class="cbp-ig-grid">
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_road"></span>
							<h4 class="cbp-ig-title">CABAÑAS INCREIBLES</h4>
							<span class="cbp-ig-category">MASAYA</span>
						</div>
					</li>
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_cube"></span>
							<h4 class="cbp-ig-title">BALCON CON VISTA NATURAL</h4>
							<span class="cbp-ig-category">MASAYA</span>
						</div>
					</li>
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_users"></span>
							<h4 class="cbp-ig-title">GRAN <br /> CAFÉ</h4>
							<span class="cbp-ig-category">MASAYA</span>
						</div>
					</li>
					<li>
						<div class="w3_grid_effect">
							<span class="cbp-ig-icon w3_ticket"></span>
							<h4 class="cbp-ig-title">COBERTURA <br /> WIFI</h4>
							<span class="cbp-ig-category">MASAYA
							</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- //banner-bottom -->
	<!-- /about -->
	<div class="about-wthree" id="about">
		<div class="container">
			<div class="ab-w3l-spa">
				<h3 class="title-w3-agileits title-black-wthree">Acerca de nuestro Masaya Glamping
				</h3>
				<p class="about-para-w3ls"> Masaya San Agustín Glamping es un lugar diseñado para quienes buscan desconectar y disfrutar de la naturaleza sin renunciar al confort. Nuestras cabañas combinan lujo y armonía con el entorno natural.
				</p>
				<img src="images/Maloka.jpg.jpeg" class="img-responsive" alt="Hair Salon">
				<div class="w3l-slider-img">
					<img src="images/estandar-4.jpg.jpeg" class="img-responsive2" alt="Hair Salon">
				</div>
				<div class="w3ls-info-about">
					<h4>Te encantarán todas las comodidades que ofrecemos
						!</h4>
					<p>que espero disfruta de tus vaciones con nosotros. </p>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!-- //about -->
	<!--sevices-->
	<div class="advantages">
		<div class="container">
			<div class="advantages-main">
				<h3 class="title-w3-agileits">Nuestros servicios
				</h3>
				<div class="advantage-bottom">
					<div class="col-md-6 advantage-grid left-w3ls wow bounceInLeft" data-wow-delay="0.3s">
						<div class="advantage-block ">
							<i class="fa fa-credit-card" aria-hidden="true"></i>
							<h4>Quédate primero, paga después! </h4>
						
							<p><i class="fa fa-check" aria-hidden="true"></i>Reserva ahora, paga en tu llegada
							</p>
							<p><i class="fa fa-check" aria-hidden="true"></i>Actividades al aire libre
							</p>

						</div>
					</div>
					<div class="col-md-6 advantage-grid right-w3ls wow zoomIn" data-wow-delay="0.3s">
						<div class="advantage-block">
							<i class="fa fa-clock-o" aria-hidden="true"></i>
							<h4>Restaurante las 24 horas
							</h4>
							
							<p><i class="fa fa-check" aria-hidden="true"></i>Gastronomía 24 horas
							</p>
							<p><i class="fa fa-check" aria-hidden="true"></i>Conexión WiFi en todo el lugar
							</p>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<!--//sevices-->
	<!-- Gallery -->
<br>
<br>
	<h3 class="title-w3-agileits title-black-wthree">Nuestra galería
		</h3>
	<section class="portfolio-w3ls" id="gallery">
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/thumb13.jpg.jpeg" class="swipebox"><img src="images/thumb13.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/superior-3.jpg.jpeg" class="swipebox"><img src="images/superior-3.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/superior-2-1.jpg.jpeg" class="swipebox"><img src="images/superior-2-1.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Suite-5-2.jpg.jpeg" class="swipebox"><img src="images/Suite-5-2.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Suite-4-1.jpg.jpeg" class="swipebox"><img src="images/Suite-4-1.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Suite-2.jpg.jpeg" class="swipebox"><img src="images/Suite-2.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/salsa_champeta-scaled.jpeg" class="swipebox"><img src="images/salsa_champeta-scaled.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Mirador.jpg.jpeg" class="swipebox"><img src="images/Mirador.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Masaya-San-Agustin_Maloca.jpg.jpeg" class="swipebox"><img src="images/Masaya-San-Agustin_Maloca.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Masaya-by-Night.jpg.jpeg" class="swipebox"><img src="images/Masaya-by-Night.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/Maloka.jpg.jpeg" class="swipebox"><img src="images/Maloka.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="col-md-3 gallery-grid gallery1">
			<a href="images/habitaciones-1.jpg.jpeg" class="swipebox"><img src="images/habitaciones-1.jpg.jpeg" class="img-responsive" alt="/">
				<div class="textbox">
					<h4>MASAYA
					</h4>
					<p><i class="fa fa-picture-o" aria-hidden="true"></i></p>
				</div>
			</a>
		</div>
		<div class="clearfix"> </div>
	</section>
	<!-- //gallery -->
	<!-- rooms & rates -->
	<div class="plans-section" id="rooms">
		<div class="container">
			<h3 class="title-w3-agileits title-black-wthree">Habitaciones y tarifas
			</h3>
			<div class="priceing-table-main">
				<div class="col-md-3 price-grid">
					<div class="price-block agile">
						<div class="price-gd-top">
							<img src="images/430817085.jpeg" alt=" " class="img-responsive" />
							<h4>Suite Ejecutiva
							</h4>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
								<ul>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star-o" aria-hidden="true"></i></li>

								</ul>
							</div>
							<div class="price-selet">
								<h3><span>$</span>800.000</h3>
                                    <a href="users/reservar.php">Reservar ahora</a>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 price-grid ">
					<div class="price-block agile">
						<div class="price-gd-top">
							<img src="images/Suite-2.jpg.jpeg" alt=" " class="img-responsive" />
							<h4>Junior Suite
							</h4>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
								<ul>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								</ul>
							</div>
							<div class="price-selet">
								<h3><span>$</span>724.200</h3>
                                  <a href="users/reservar.php">Reservar ahora</a>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 price-grid lost">
					<div class="price-block agile">
						<div class="price-gd-top">
							<img src="images/Familiar1.jpg.jpeg" alt=" " class="img-responsive" />
							<h4>Habitación Familiar</h4>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
								<ul>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								</ul>
							</div>
							<div class="price-selet">
								<h3><span>$</span>533.620</h3>
                                  <a href="users/reservar.php">Reservar ahora</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 price-grid wthree lost">
					<div class="price-block agile">
						<div class="price-gd-top ">
							<img src="images/superior-3.jpg.jpeg" alt=" " class="img-responsive" />
							<h4>HHabitación Estándar</h4>
						</div>
						<div class="price-gd-bottom">
							<div class="price-list">
								<ul>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star" aria-hidden="true"></i></li>
									<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
								</ul>
							</div>
							<div class="price-selet">
								<h3><span>$</span>457.000</h3>
                                  <a href="users/reservar.php">Reservar ahora</a>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!--// rooms & rates -->
	<!-- visitors -->
	<div class="w3l-visitors-agile">
		<div class="container">
			<h3 class="title-w3-agileits title-black-wthree">Qué otros visitantes experimentaron
			</h3>
		</div>
		<div class="w3layouts_work_grids">
			<section class="slider">
				<div class="flexslider">
					<ul class="slides">
						<li>
							<div class="w3layouts_work_grid_left">
								<img src="images/Masaya-San-Agustin_Maloca.jpg.jpeg" alt=" " class="img-responsive" />
								<div class="w3layouts_work_grid_left_pos">
									<img src="images/539151418_18523812016032804_4060176253006855827_n.jpg" alt=" " class="img-responsive" />
								</div>
							</div>
							<div class="w3layouts_work_grid_right">
								<h4>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									Vale la pena volver

								</h4>
								<p>es fascinantes y divertido pase momentos agradables de mis vaciones en este glamping.</p>
								<h5>Julia Lopez</h5>
								<p>Medellín</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
							<div class="w3layouts_work_grid_left">
								<img src="images/Familiar2.jpg.jpeg" alt=" " class="img-responsive" />
								<div class="w3layouts_work_grid_left_pos">
									<img src="images/491422311_17904272616158146_784270540535930039_n.jpg" alt=" " class="img-responsive" />
								</div>
							</div>
							<div class="w3layouts_work_grid_right">
								<h4>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star-o" aria-hidden="true"></i>
									Ya quiero volver

								</h4>
								<p>Pasé momentos increibles con personas muy importantes para mi, love Masaya </p>
								<h5>Laura Rivera</h5>
								<p>Estados Unidos
								</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
							<div class="w3layouts_work_grid_left">
								<img src="images/Masaya-by-Night.jpg.jpeg" alt=" " class="img-responsive" />
								<div class="w3layouts_work_grid_left_pos">
									<img src="images/Web_MC_IG_3-260x300.png" alt=" " class="img-responsive" />
								</div>
							</div>
							<div class="w3layouts_work_grid_right">
								<h4>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star-o" aria-hidden="true"></i>
									Ningun lugar como este

								</h4>
								<p>Este es un lugar maravilloso y hermoso, se los recomiendo al 100%</p>
								<h5>Andrea Ochoa</h5>
								<p>Bogota</p>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li>
							<div class="w3layouts_work_grid_left">
								<img src="images/DSC5836-HDR.jpg.jpeg" alt=" " class="img-responsive" />
								<div class="w3layouts_work_grid_left_pos">
									<img src="images/experiencia1234.jpg" alt=" " class="img-responsive" />
								</div>
							</div>
							<div class="w3layouts_work_grid_right">
								<h4>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star-o" aria-hidden="true"></i>
									<i class="fa fa-star-o" aria-hidden="true"></i>
									Extraño allí
								</h4>
								<p>Hermosas vistas y espectacular comida, yo volvería siempre</p>
								<h5>Angie Fierro</h5>
								<p>Melgar</p>
							</div>
							<div class="clearfix"> </div>
						</li>
					</ul>
				</div>
			</section>
		</div>
	</div>
	<!-- visitors -->
	<!-- contact -->
	<section class="contact-w3ls" id="contact">
		<div class="container">
			<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile2" data-aos="flip-left">
				<div class="contact-agileits">
					<h4>Registrate
					</h4>
					<p class="contact-agile2">registrate para estar al tanto de todo
					</p>
					<form action="guardar_cliente.php" method="POST">
  <!-- Primer Nombre -->
  <div class="form-group">
    <label for="nombre">Primer Nombre:</label>
    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa tu primer nombre" required>
  </div>

  <!-- Segundo Nombre -->
  <div class="form-group">
    <label for="segundo_nombre">Segundo Nombre:</label>
    <input type="text" class="form-control" name="segundo_nombre" id="segundo_nombre" placeholder="Ingresa tu segundo nombre (opcional)">
  </div>

  <!-- Primer Apellido -->
  <div class="form-group">
    <label for="apellido">Primer Apellido:</label>
    <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Ingresa tu primer apellido" required>
  </div>

  <!-- Segundo Apellido -->
  <div class="form-group">
    <label for="segundo_apellido">Segundo Apellido:</label>
    <input type="text" class="form-control" name="segundo_apellido" id="segundo_apellido" placeholder="Ingresa tu segundo apellido (opcional)">
  </div>

  <!-- Correo Electrónico -->
  <div class="form-group">
    <label for="correo">Correo Electrónico:</label>
    <input type="email" class="form-control" name="correo" id="correo" placeholder="Ingresa tu correo" required>
  </div>

  <!-- Contraseña -->
  <div class="form-group">
    <label for="contraseña">Contraseña:</label>
    <input type="password" class="form-control" name="contrasena" id="contraseña" placeholder="Ingresa tu contraseña" required>
  </div>

  <!-- Celular -->
  <div class="form-group">
    <label for="celular">Celular:</label>
    <input type="text" class="form-control" name="celular" id="celular" placeholder="Ingresa tu número de celular" required>
  </div>

  <!-- Dirección -->
  <div class="form-group">
    <label for="direccion">Dirección:</label>
    <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Ingresa tu dirección">
  </div>

  <!-- Botón de envío -->
  <input type="submit" class="btn btn-primary" value="Registrar">
</form>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 contact-w3-agile1" data-aos="flip-right">
				<h4>Conectate con nosotros
				</h4>
				<p class="contact-agile1"><strong>Teléfono :</strong>+57 312 4187927</p>
				<p class="contact-agile1"><strong>Dirección :</strong> Vereda El Tablon, km 1 Vía del, Via Estrecho del Magdalena, San Agustín, Huila</p>
				<p class="contact-agile1"><strong>Correo :</strong>SANAGUSTIN@MASAYA-EXPERIENCE.COM</p>

				<div class="social-bnr-agileits footer-icons-agileinfo">
					<ul class="social-icons3">
						<li><a href="#" class="fa fa-facebook icon-border facebook"> </a></li>
						<li><a href="#" class="fa fa-twitter icon-border twitter"> </a></li>
						<li><a href="#" class="fa fa-google-plus icon-border googleplus"> </a></li>

					</ul>
				</div>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.6343827453697!2d-76.2683301!3d1.895837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e25707f01ae31c7%3A0xccd64e01b1e32fe2!2sCeiba%20by%20Masaya%20Collection!5e0!3m2!1ses!2sco!4v1761536808272!5m2!1ses!2sco"></iframe>
			</div>
			<div class="clearfix"></div>
		</div>
	</section>
	<!-- /contact -->
	<div class="copy">
		<p>© 2025 <a href="index.php">SANTIAGO HERNANDEZ</a> </p>
	</div>
	<!--/footer -->
	<!-- js -->
	<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
	<!-- contact form -->
	<script src="js/jqBootstrapValidation.js"></script>

	<!-- /contact form -->
	<!-- Calendar -->
	<script src="js/jquery-ui.js"></script>
	<script>
		$(function() {
			$("#datepicker,#datepicker1,#datepicker2,#datepicker3").datepicker();
		});
	</script>
	<!-- //Calendar -->
	<!-- gallery popup -->
	<link rel="stylesheet" href="css/swipebox.css">
	<script src="js/jquery.swipebox.min.js"></script>
	<script type="text/javascript">
		jQuery(function($) {
			$(".swipebox").swipebox();
		});
	</script>
	<!-- //gallery popup -->
	<!-- start-smoth-scrolling -->
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<!-- start-smoth-scrolling -->
	<!-- flexSlider -->
	<script defer src="js/jquery.flexslider.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "slide",
				start: function(slider) {
					$('body').removeClass('loading');
				}
			});
		});
	</script>
	<!-- //flexSlider -->
	<script src="js/responsiveslides.min.js"></script>
	<script>
		// You can also use "$(window).load(function() {"
		$(function() {
			// Slideshow 4
			$("#slider4").responsiveSlides({
				auto: true,
				pager: true,
				nav: false,
				speed: 500,
				namespace: "callbacks",
				before: function() {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function() {
					$('.events').append("<li>after event fired.</li>");
				}
			});

		});
	</script>
	<!--search-bar-->
	<script src="js/main.js"></script>
	<!--//search-bar-->
	<!--tabs-->
	<script src="js/easy-responsive-tabs.js"></script>
	<script>
		$(document).ready(function() {
			$('#horizontalTab').easyResponsiveTabs({
				type: 'default', //Types: default, vertical, accordion           
				width: 'auto', //auto or any width like 600px
				fit: true, // 100% fit in a container
				closed: 'accordion', // Start closed if in accordion view
				activate: function(event) { // Callback function if tab is switched
					var $tab = $(this);
					var $info = $('#tabInfo');
					var $name = $('span', $info);
					$name.text($tab.text());
					$info.show();
				}
			});
			$('#verticalTab').easyResponsiveTabs({
				type: 'vertical',
				width: 'auto',
				fit: true
			});
		});
	</script>
	<!--//tabs-->
	<!-- smooth scrolling -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
			$().UItoTop({
				easingType: 'easeOutQuart'
			});
		});
	</script>

	<div class="arr-w3ls">
		<a href="#home" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	</div>
	<!-- //smooth scrolling -->
	<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>

	<!-- Botón flotante de WhatsApp -->
        <a href="https://wa.me/+5491176011408?text=Quiero%20más%20información%20para%20reservar" target="_blank" class="whatsapp-btn btn btn-primary">
            <i class="glyphicon glyphicon-phone"></i>
        </a>

	<script>
        function copyToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Mensaje copiado al portapapeles. Pégalo en la ventana de chat de WhatsApp.');
        }
    </script>
	<!-- Fin Botón flotante de WhatsApp -->

</body>

</html>