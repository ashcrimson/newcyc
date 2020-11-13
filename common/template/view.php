<?php



namespace TemplateCYC;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewTemplateCYC {
	
	public function output(\TemplateCYC\ModelTemplateCYC $model, string $content){
	// public function output(array $arr){
		session_start();

		if(!isset($_SESSION["mail"])){
			header("Location: ". base() . "/login");
		}else{
			$model = $model->mail($_SESSION["mail"]);
			$permisos = $model->get()[0];
//			 print_r($permisos);
		}
		ob_start();
		
		?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Practicante">

	<!-- CSRF Token -->
	<!--    <meta name="csrf-token" content="{{ csrf_token() }}"> -->

	<!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

	<!-- Scripts -->
	<script src="<?=base();?>/assets/js/app.js" defer></script>

	<!-- Plantilla -->
	<!-- Bootstrap core CSS-->
	<link href="<?=base();?>/assets/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom fonts for this template-->
	<link href="<?=base();?>/assets/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- Page level plugin CSS-->
	<link href="<?=base();?>/assets/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?=base();?>/assets/assets/frontend/css/sb-admin.css" rel="stylesheet">

	<!-- Css selectize selectpicker-->
	<link rel="stylesheet" href="<?=base();?>/assets/assets/frontend/css/normalize.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base();?>/assets/assets/frontend/css/selectize.default.css" rel="stylesheet">

</head>

<body id="page-top">
	<nav class="navbar navbar-expand-md navbar-dark bg-dark static-top">
		<a class="navbar-brand mr-1" href="<?=base();?>/">Bienvenido</a>

		<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
			<i class="fas fa-bars"></i>
		</button>

		<!-- Navbar -->
		<ul class="navbar-nav form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
			<!-- Authentication Links -->
<!-- 			@guest
			<li class="nav-item">
				<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
			</li>

			@else
		-->
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
				<i class="fas fa-user-circle fa-fw"></i>
				<!-- {{ Auth::user()->nombre }} --> <?=$_SESSION["nombre"];?><span class="caret"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="<?=base();?>/logout" data-toggle="modal" data-target="#logoutModal">
					Cerrar sesion
				</a>
				<form id="logout-form" action="<?=base();?>/logout" method="POST" style="display: none;">
					@csrf
				</form>
			</div>
		</li>

		<!-- @endguest -->
	</ul>
</nav>

<div id="wrapper">
	<!-- Sidebar -->
	<ul class="sidebar navbar-nav">
		<li class="nav-item">
			<a class="nav-link" href="<?=base();?>/">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Home</span>
			</a>
		</li>
		<!-- @hasanyrole('SuperAdmin|Admin|Comprador') -->
		<?php
		if( ($permisos["ID_PERMISO"] == 1) ||
			($permisos["ID_PERMISO"] == 2) ||
			($permisos["ID_PERMISO"] == 3)){
				?>

		<li class="nav-item dropdown">
			<a class="nav-link" href="<?=base();?>/licitaciones" id="pagesDropdown" role="button" >
				<i class="fas fa-file-signature"></i>
				<span>Licitaciones</span>
			</a>
		</li>
			<?php
		}
		?>
		<!-- @endrole -->
		<li class="nav-item dropdown">
			<a class="nav-link" href="<?=base();?>/contratos" id="pagesDropdown" role="button">
				<i class="fas fa-file-signature"></i>
				<span>Contratos</span>
			</a>

		</li>

		<!-- @hasanyrole('SuperAdmin|Admin|Comprador') -->
		<?php
		if( ($permisos["ID_PERMISO"] == 1) ||
			($permisos["ID_PERMISO"] == 2) ||
			($permisos["ID_PERMISO"] == 3)){
				?>

		<li class="nav-item dropdown">
			<a class="nav-link" href="<?=base();?>/ordenCompra" id="pagesDropdown" role="button">
				<i class="fas fa-file-signature"></i>
				<span>Órdenes de Compra</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">
				<a class="dropdown-item" href="<?=base();?>/ordenCompra">Buscar</a>
				<div class="dropdown-divider"></div> 
				<a class="dropdown-item" href="<?=base();?>/ordenCompra/new">Agregar</a>
			</div>
		</li>
			<?php
		}
		?>
		<!-- @endrole -->

		<!-- @hasanyrole('SuperAdmin|Admin') -->
		<?php
		if( ($permisos["ID_PERMISO"] == 1) ||
			($permisos["ID_PERMISO"] == 2)){
				?>

		<!-- <li class="nav-item">
			<a class="nav-link" href="{{ route('convenios.index') }}">
				<i class="fas fa-file-signature"></i>
				<span>Convenios</span>
			</a>
		</li>
 -->
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-exclamation-triangle"></i>
				<span>Alertas</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">
				<a class="dropdown-item" href="<?=base();?>/alertaContrato">Contratos</a>
				<!-- <div class="dropdown-divider"></div> 
				<a class="dropdown-item" href="<?=base();?>/alertaConvenio">Convenios</a> -->
			</div>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="<?=base();?>/usuarios">
				<i class="fas fa-fw fa-user-circle"></i>
				<span>Usuarios</span>
			</a>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-fw fa-folder"></i>
				<span>Mantenedores</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">
				<a class="dropdown-item" href="<?=base();?>/cargos">Cargos</a>
				<a class="dropdown-item" href="<?=base();?>/monedas">Monedas</a>
				<div class="dropdown-divider"></div>    
				<!-- <a class="dropdown-item" href="<?=base();?>/prestaciones">Prestaciones</a> -->
				<a class="dropdown-item" href="<?=base();?>/proveedores">Proveedores</a>
			</div>
		</li>
		<!-- <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-fw fa-book"></i>
				<span>Reportes</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="pagesDropdown">
				<a class="dropdown-item" href="<?=base();?>/creportes">Contrato</a>
				<div class="dropdown-divider"></div> 
				<a class="dropdown-item" href="<?=base();?>/cvreportes">Convenio</a>
			</div>
		</li>   -->
			<?php
		}
		?>
		<!-- @endrole -->
	</ul>
	<div id="content-wrapper">
		<div class="container-fluid">
			<!-- Breadcrumbs-->
				<!-- @if (session()->has('success'))
				<div class="container col">
					<div class="alert alert-success">{{ session('success') }}</div>
				</div>
				@endif
				@if (session()->has('error'))
				<div class="container col">
					<div class="help-block text-danger">Error al guardar los datos</div>
				</div>  
				@endif

				@yield('content') -->


				<?php

				echo $content;

				?>



			</div>
			<!-- /.container-fluid -->

			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright © Contratos y Convenios 2019</span>
					</div>
				</div>
			</footer>
		</div>
		<!-- /.content-wrapper -->   
	</div>
	<!-- /#wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>

					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-primary" href="<?=base();?>/logout"
					onclick="event.preventDefault();
					document.getElementById('logout-form').submit();">
					Salir
				</a>
			</div>
		</div>
	</div>
</div>

<!--  Bootstrap core JavaScript -->
<script src="<?=base();?>/assets/assets/frontend/js/popper.js"></script>
<script src="<?=base();?>/assets/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?=base();?>/assets/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=base();?>/assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>   

<!-- Core plugin JavaScript -->
<script src="<?=base();?>/assets/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!--   Custom scripts for all pages -->
<script src="<?=base();?>/assets/assets/frontend/js/sb-admin.min.js"></script>

</body>
</html>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
		
	}
}