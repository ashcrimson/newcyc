<?php



namespace ContratosNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(\ContratosNew\ModelContratos $model){

		if(!empty($_POST)){
			$model->execute();
        }
        
        $data = $model->get();

		$dataProveedores = $data[0];
		$dataLicitaciones = $data[1];
		$dataMoneda = $data[2];
		$dataCargos = $data[3];

		$id_contrato = false;
		$nro_licitacion = false;
		$rut_proveedor = false;
        $id_area = false;
        $id_admin = false;
        $id_moneda = false;
        $tipo = false;
        $monto = false;
        $estado_alerta = false;
        $fecha_inicio = false;
        $fecha_termino = false;
        $fecha_aprobacion = false;
        $fecha_alerta_vencimiento = false;
        $fecha_creacion = false;
        $fecha_actualizacion = false;
        $fecha_eliminacion = false;


		if(sizeof($_GET)){
			if(!isset($_GET["id_contrato"])){
				$id_contrato = !$id_contrato;
			}
			if(!isset($_GET["nro_licitacion"])){
				$nro_licitacion = !$nro_licitacion;
			}
			if(!isset($_GET["rut_proveedor"])){
				$rut_proveedor = !$rut_proveedor;
			}
			if(!isset($_GET["id_area"])){
				$id_area = !$id_area;
            }
            if(!isset($_GET["id_admin"])){
				$id_admin = !$id_admin;
            }
            if(!isset($_GET["id_moneda"])){
				$id_moneda = !$id_moneda;
            }
            if(!isset($_GET["tipo"])){
				$tipo = !$tipo;
            }
            if(!isset($_GET["monto"])){
				$monto = !$monto;
            }
            if(!isset($_GET["estado_alerta"])){
				$estado_alerta= !$estado_alerta;
            }
            if(!isset($_GET["fecha_inicio"])){
				$fecha_inicio = !$fecha_inicio;
            }
            if(!isset($_GET["fecha_termino"])){
				$fecha_termino = !$fecha_termino;
            }
            if(!isset($_GET["fecha_aprobacion"])){
				$fecha_aprobacion = !$fecha_aprobacion;
            }
            if(!isset($_GET["fecha_alerta_vencimiento"])){
				$fecha_alerta_vencimiento = !$fecha_alerta_vencimiento;
            }
            if(!isset($_GET["fecha_creacion"])){
				$fecha_creacion = !$fecha_creacion;
            }
            if(!isset($_GET["fecha_actualizacion"])){
				$fecha_actualizacion = !$fecha_actualizacion;
            }
            if(!isset($_GET["fecha_eliminacion"])){
				$fecha_eliminacion = !$fecha_eliminacion;
			}
		}

//print_r(sizeof($_GET));
		ob_start();

		?>




		<!-- Habilitar nombre de archivo adjunto-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

		<?php
		//valida si es admin
		?>
		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
                <a href="<?=base("/contratos/new");?>">Contratos</a>
			</li>
			<!-- <li class="breadcrumb-item active">Mantenedor</li> -->
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<form method="post" class="form-horizontal" action="<?=base();?>/contratos/new" enctype="multipart/form-data">
					<!-- {!! csrf_field() !!} -->
					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('id_contrato') ? 'has-error' : '' }}">
								<label>ID Contrato</label>
								<input type="hidden" name="submit" value="true">
								<input type="text" name="id_contrato" class="form-control" value="<?=isset($_GET["id_contrato"]) ? $_GET["id_contrato"]: '' ?>">

								<?php if ($id_contrato){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Numero de contrato vacio</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>


					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Número Licitación</label>
								<input type="number" name="nro_licitacion" class="form-control" value="<?=$_GET["nro_licitacion"] ?: '' ?>">

								<?php if ($nro_licitacion){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Número licitación inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Rut Proveedor</label>
								<input type="number" name="rut_proveedor" class="form-control" value="<?=$_GET["rut_proveedor"] ?: '' ?>">

								<?php if ($rut_proveedor){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: RUT proveedor inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>ID Área</label>
								<input type="number" name="id_area" class="form-control" value="<?=$_GET["id_area"] ?: '' ?>">

								<?php if ($id_area){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: ID Área inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>ID Admin</label>
								<input type="number" name="id_admin" class="form-control" value="<?=$_GET["id_admin"] ?: '' ?>">

								<?php if ($id_admin){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: ID Admin inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>ID Moneda</label>
								<input type="number" name="id_moneda" class="form-control" value="<?=$_GET["id_moneda"] ?: '' ?>">

								<?php if ($id_moneda){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: ID Admin inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Tipo</label>
								<input type="text" name="tipo" class="form-control" value="<?=$_GET["tipo"] ?: '' ?>">

								<?php if ($tipo){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Tipo inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Monto</label>
								<input type="number" name="monto" class="form-control" value="<?=$_GET["monto"] ?: '' ?>">

								<?php if ($monto){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Monto inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Estado Alerta</label>
								<input type="number" name="estado_alerta" class="form-control" value="<?=$_GET["estado_alerta"] ?: '' ?>">

								<?php if ($estado_alerta){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Estado Alerta inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Inicio</label>
								<input type="date" name="fecha_inicio" class="form-control" value="<?=$_GET["fecha_inicio"] ?: '' ?>">

								<?php if ($fecha_inicio){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Inicio inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Término</label>
								<input type="date" name="fecha_termino" class="form-control" value="<?=$_GET["fecha_termino"] ?: '' ?>">

								<?php if ($fecha_termino){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Término inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Aprobación</label>
								<input type="date" name="fecha_aprobacion" class="form-control" value="<?=$_GET["fecha_aprobacion"] ?: '' ?>">

								<?php if ($fecha_aprobacion){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Aprobación inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Alerta Vencimienton</label>
								<input type="date" name="fecha_alerta_vencimiento" class="form-control" value="<?=$_GET["fecha_alerta_vencimiento"] ?: '' ?>">

								<?php if ($fecha_alerta_vencimiento){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Alerta Vencimiento inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Creación</label>
								<input type="date" name="fecha_creacion" class="form-control" value="<?=$_GET["fecha_creacion"] ?: '' ?>">

								<?php if ($fecha_creacion){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Creación inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Actualización</label>
								<input type="date" name="fecha_actualizacion" class="form-control" value="<?=$_GET["fecha_actualizacion"] ?: '' ?>">

								<?php if ($fecha_actualizacion){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Actualización inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Eliminación</label>
								<input type="date" name="fecha_eliminacion" class="form-control" value="<?=$_GET["fecha_eliminacion"] ?: '' ?>">

								
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Objeto Contrato</label>
								<input type="text" name="objeto_contrato" class="form-control" value="<?=$_GET["objeto_contrato"] ?: '' ?>">

							
							</div>
						</div>
					</div>
					
					<br>    

					<div class="card-footer">
						<div class="row">
							<div class="col-sm-8">
								<button type="submit" class="btn-primary btn rounded" ><i class="icon-floppy-disk"></i> Guardar</button>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

		<!-- {{-- Script para mostrar nombre archivo en el select --}} -->
		<script>
			$(".custom-file-input").on("change", function() {
				var fileName = $(this).val().split("\\").pop();
				$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});
		</script>

		<script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
		<script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
		<script>
			$('.selectField').selectize({
				create: false,
				sortField: {
					field: 'text',
					direction: 'asc'
				},
				dropdownParent: 'body'
			});
		</script>  







		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}