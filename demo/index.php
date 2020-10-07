<?php
	require_once("db_.php");
	if(!isset($_SESSION['idpersona']) or strlen($_SESSION['idpersona'])==0 or $_SESSION['autoriza']==0){
		header("location: ../demo/login/");
	}
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<title>Un mundo para tus pies</title>
	<link rel="icon" type="image/png" href="img/favicon.ico">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">

	<link rel="stylesheet" href="lib/load/css-loader.css">
	<link rel="stylesheet" type="text/css" href="lib/modulos.css"/>
</head>

<body>


<header class="d-block p-2" id='header'>
	<nav class='barraprincipal navbar navbar-expand-sm fixed-top navbar-light bg-light text-'  style='background-color: #2e4053 !important; color: white !important;'>
	  <img src='img/sagyc.png' width='60' height='30' alt=''>
	  <a class='navbar-brand text-white text-center ml-3' href='#'> <?php echo $_SESSION['nombre_sis']; ?>  </a>
	  <button class='navbar-toggler collapsed' type='button' data-toggle='collapse' data-target='#navbarsExample06' aria-controls='navbarsExample06' aria-expanded='false' aria-label='Toggle navigation'>
	    <span class='navbar-toggler-icon'></span>
	  </button>
	  <div class='navbar-collapse collapse' id='navbarsExample06' style=''>
	    <ul class='navbar-nav mr-auto'>
	    </ul>
	      <ul class='nav navbar-nav navbar-right text-white' id='fondo'></ul>
	      <ul class='nav navbar-nav navbar-right'>
	        <li class='nav-item'>
	          <a class='nav-link pull-left text-white' onclick='salir()'>
	            <i class='fas fa-sign-out-alt'></i> Salir
	          </a>
	        </li>
	      </ul>
	  </div>
	</nav>
</header>

<div class="page-wrapper d-block p-2" id='bodyx'>
	<div class='wrapper' >
	  <div class='content navbar-default'>
	    <div class='container-fluid'>
	      <div class='sidebar sidenav' id='navx'>
	        <a href='#dash/index' is='menu-link' class='activeside'><i class='fas fa-home'></i><span>Inicio</span></a>
					<a href='#a_productos/index' is='menu-link' title='Productos'><i class='fab fa-product-hunt'></i><span>Productos</span></a>
	        <a href='#a_ventas/index' is='menu-link' title='Pedidos'><i class='fas fa-shopping-basket'></i><span>Ventas</span></a>
					<a href='#a_cliente/index' is='menu-link' title='Clientes'><i class='fas fa-user-tag'></i><span>Clientes</span></a>
	        <a href='#a_citas/index' is='menu-link' title='Citas'><i class="far fa-calendar-check"></i><span>Citas</span></a>
	        <hr>
					<a href='#a_usuarios/index' is='menu-link' title='Usuarios'><i class='fas fa-users'></i> <span>Usuarios</span></a>
	        <a href='#a_datosemp/index' is='menu-link' title='Datosemp'><i class="fas fa-wrench"></i><span>Datos Emp.</span></a>
	      </div>
	    </div>
	    <div class='fijaproceso main' id='contenido'>
	    </div>
	  </div>
	</div>
</div>

<div class="modal animated fadeInDown" tabindex="-1" role="dialog" id="myModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" id='modal_dispo'>
		<div class="modal-content" id='modal_form'>

		</div>
	</div>
</div>

<div class="loader loader-default is-active" id='cargando_div' data-text="Cargando">
	<h2><span style='font-color:white'></span></h2>
</div>

</body>
	<!--   Core JS Files   -->
	<script src="lib/jquery-3.5.1.js" type="text/javascript"></script>

	<!--   url   -->
	<script src="lib/jquery/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="lib/jquery/jquery-ui.min.css" />

	<!-- Animation library for notifications   -->
  <link href="lib/animate.css" rel="stylesheet"/>

	<!-- WYSWYG   -->
	<link href="lib/summernote8.12/summernote-lite.css" rel="stylesheet" type="text/css">
  <script src="lib/summernote8.12/summernote-lite.js"></script>
	<script src="lib/summernote8.12/lang/summernote-es-ES.js"></script>

	<!--   Alertas   -->
	<script src="lib/swal/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="lib/swal/dist/sweetalert2.min.css">

	<!--   para imprimir   -->
	<script src="lib/VentanaCentrada.js" type="text/javascript"></script>

	<!--   Cuadros de confirmación y dialogo   -->
	<link rel="stylesheet" href="lib/jqueryconfirm/css/jquery-confirm.css">
	<script src="lib/jqueryconfirm/js/jquery-confirm.js"></script>

	<!--   iconos   -->
	<link rel="stylesheet" href="lib/fontawesome-free-5.12.1-web/css/all.css">

	<!--   carrusel de imagenes   -->
	<link rel="stylesheet" href="lib/baguetteBox.js-dev/baguetteBox.css">
	<script src="lib/baguetteBox.js-dev/baguetteBox.js" async></script>
	<script src="lib/baguetteBox.js-dev/highlight.min.js" async></script>

	<script src="lib/popper.js"></script>
	<script src="lib/tooltip.js"></script>

	<!--   Propios   -->
	<script src="sagyc.js"></script>
	<script src="vainilla.js"></script>

	<link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="lib/modulos.css"/>

	<!--- calendario -->
	<link href='lib/fullcalendar-4.0.1/packages/core/main.css' rel='stylesheet' />
	<link href='lib/fullcalendar-4.0.1/packages/daygrid/main.css' rel='stylesheet' />
	<link href='lib/fullcalendar-4.0.1/packages/timegrid/main.css' rel='stylesheet' />

	<script src='lib/fullcalendar-4.0.1/packages/core/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/interaction/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/daygrid/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/timegrid/main.js'></script>
	<script src='lib/fullcalendar-4.0.1/packages/core/locales/es.js'></script>

	<!--   Boostrap   -->
	<link rel="stylesheet" href="lib/boostrap/css/bootstrap.min.css">
	<script src="lib/boostrap/js/bootstrap.js"></script>
</html>
