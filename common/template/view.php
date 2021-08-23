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
			$authUser = authUser($model->pdo);

			if ($authUser['ESTADO'] == 'INACTIVO'){
			    flash('Usuario inactivo' )->error();
			    redirect('/login');

            }
//			 print_r($permisos);
		}
		ob_start();
		
		?>
<!DOCTYPE html>
<html lang="">
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
<!--	<link href="--><?//=base();?><!--/assets/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">-->

	<!-- Custom styles for this template-->
	<link href="<?=base();?>/assets/assets/frontend/css/sb-admin.css" rel="stylesheet">

	<!-- Css selectize selectpicker-->
	<link rel="stylesheet" href="<?=base();?>/assets/assets/frontend/css/normalize.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base();?>/assets/assets/frontend/css/selectize.default.css" rel="stylesheet">

    <link rel="stylesheet" href="<?=base();?>/assets/assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base();?>/assets/assets/vendor/vue-multiselect.min.css" rel="stylesheet">

	<style>
		.navbar-dark .navbar-nav .nav-link {
			color: white;
		}

		.sidebar .nav-item .nav-link span{
			color: white;
			
		}
		.skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a, .skin-blue .sidebar-menu>li.menu-open>a {
			color: #fff;
			background: #1e282c;
		}

		.sidebar-menu, .main-sidebar .user-panel, .sidebar-menu>li.header {
			white-space: nowrap;
			overflow: hidden;
		}

		.elmenu {
			color: rgba(255, 255, 255, 0.5);
			text-decoration: none;
		}

		.elmenu:hover {
			color: #fff;
			text-decoration: none;
		}

		.treeview {
			text-align: left;
		}

		::marker {
			unicode-bidi: isolate;
			font-variant-numeric: tabular-nums;
			text-transform: none;
			text-indent: 0px !important;
			text-align: start !important;
			text-align-last: start !important;
		}

		.sidebar-menu, .main-sidebar .user-panel, .sidebar-menu>li.header {
			white-space: nowrap;
			overflow: hidden;
		}

		.user-panel {
			position: relative;
			width: 100%;
			padding: 10px;
			overflow: hidden;
			height: 110px;
			color: rgba(255, 255, 255, 0.5);
		}

		.user-panel:before, .user-panel:after {
			content: " ";
			display: table;
		}

		.sidebar-menu, .main-sidebar .user-panel, .sidebar-menu>li.header {
			white-space: nowrap;
			overflow: hidden;
		}

		.pull-left {
			float: left!important;
		}

		.user-panel>.image>img {
			width: 100%;
			max-width: 45px;
			height: auto;
		}

		.skin-blue .user-panel>.info, .skin-blue .user-panel>.info>a {
			color: #fff;
		}

		.user-panel>.info {
			padding: 5px 5px 5px 15px;
			line-height: 1;
			position: absolute;
			left: 55px;
			color: #fff;
		}

		.user-panel>.info>p {
			font-weight: 600;
			margin-bottom: 9px;
			font-size:14px;
		}

		.user-panel>.info>a {
			text-decoration: none;
			padding-right: 5px;
			margin-top: 3px;
			font-size: 11px;
			color: #fff;
		}

		.encabezado {
			font-size: 24px;
			color: #333;
			
		}

		.encabezado:hover {
			text-decoration: none;
			color: #000;
		}

		.breadcrumb-item.active {
			margin-top: 10px;
			
			
		}

		
	</style>

</head>

<body id="page-top">
	<nav class="navbar navbar-expand-md navbar-dark bg-dark static-top" style="background-color:#3c8dbc !important;">
		<a class="navbar-brand mr-1 ml-5" href="<?=base();?>/">Bienvenido</a>

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

        <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=base();?>/assets/img/Admin-User-256.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?=$_SESSION["nombre"];?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

            <li class="nav-item">
                <a class="nav-link" href="<?=base();?>/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span>
                </a>
            </li>
            <!-- @hasanyrole('SuperAdmin|Admin|Comprador') -->
            <?php
            if( ($permisos["ID_PERMISO"] == 1)){
                ?>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="<?=base();?>/licitaciones" id="pagesDropdown" role="button" >
                    <i class="fas fa-book"></i>
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

                ($permisos["ID_PERMISO"] == 3)){
                    ?>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="<?=base();?>/ordenCompra" id="pagesDropdown" role="button">
                    <i class="fa fa-file"></i>
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
            if( ($permisos["ID_PERMISO"] == 1) ){
                    ?>

            <!-- <li class="nav-item">
                <a class="nav-link" href="{{ route('convenios.index') }}">
                    <i class="fas fa-file-signature"></i>
                    <span>Convenios</span>
                </a>
            </li>
     -->


            <li class="nav-item dropdown">

                <ul class="sidebar-menu  " data-widget="tree">


                <!-- <li class="treeview " style="height: auto; text-align:left; margin-left:-22px; padding-top:10px;">
                  <a href="#" class="elmenu">
                    <i class="fa fa-exclamation-triangle"></i>
                    <span style="color:#fff;">Alertas</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-right pull-right" style="padding-left:102px;"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu elmenu" style="display: none;">
                    <li ><a href="<?=base();?>/alertaContrato" class="elmenu"><i class="fa fa-circle-o"></i> Contratos</a></li>

                  </ul>
                </li> -->


                </ul>
              </li>



            <li class="nav-item dropdown" style="padding-top:10px;">
                <ul class="sidebar-menu  " data-widget="tree">


                    <li class="treeview " style="height: auto; text-align:left; margin-left:-22px; padding-top:10px;">
                      <a href="#" class="elmenu">
                        <i class="fa fa-folder"></i>
                        <span style="padding-left:2px;  color:#fff;">Mantenedores</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-right pull-right" style="padding-left:50px;"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu elmenu" style="display: none;">
                        <li ><a href="<?=base();?>/cargos" class="elmenu"><i class="fa fa-circle-o"></i> Cargos</a></li>
                        <li><a href="<?=base();?>/monedas" class="elmenu"><i class="fa fa-circle-o"></i> Monedas</a></li>
                        <li><a href="<?=base();?>/proveedores" class="elmenu"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                        <li><a href="<?=base();?>/areas" class="elmenu"><i class="fa fa-circle-o"></i> Areas</a></li>
                        <!-- <li><a href="<?=base();?>/prestaciones" class="elmenu"><i class="fa fa-circle-o"></i> Prestaciones</a></li> -->
                      </ul>
                    </li>


                  </ul>
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

            <?php
            if( ($permisos["ID_PERMISO"] == 1)  ||

                ($permisos["ID_PERMISO"] == 2)){
                ?>
            <li class="nav-item" style="padding-top:10px;">
                <a class="nav-link" href="<?=base();?>/usuarios">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Usuarios</span>
                </a>
            </li>
                <?php
            }
            ?>
        </ul>

        <div id="content-wrapper">
                <div class="container-fluid">
                    <?php echo $content; ?>
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

    <!-- Slimscroll -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="https://adminlte.io/themes/AdminLTE/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="https://adminlte.io/themes/AdminLTE/dist/js/demo.js"></script>


</body>
</html>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
		
	}
}