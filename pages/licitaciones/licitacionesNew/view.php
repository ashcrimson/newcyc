<?php



namespace LicitacionesNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewLicitaciones {
	
	public function output(\LicitacionesNew\ModelLicitaciones $model){

		if(!empty($_POST)){
			$model->execute();
		}

		$nro_licitacion = false;
		$presupuesto = false;
		$archivo_licitacion = false;
		$descripcion_licitacion = false;


		if(sizeof($_GET)){
			if(!isset($_GET["nro_licitacion"])){
				$nro_licitacion = !$nro_licitacion;
			}
			if(!isset($_GET["presupuesto"])){
				$presupuesto = !$presupuesto;
			}
			if(!isset($_GET["archivo_licitacion"])){
				$archivo_licitacion = !$archivo_licitacion;
			}
			if(!isset($_GET["descripcion_licitacion"])){
				$descripcion_licitacion = !$descripcion_licitacion;
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
				<a href="<?=base();?>/licitaciones">Licitaciones</a>
			</li>
			<!-- <li class="breadcrumb-item active">Mantenedor</li> -->
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<form method="post" class="form-horizontal" action="<?=base();?>/licitaciones/new" enctype="multipart/form-data">
					<!-- {!! csrf_field() !!} -->
					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nro_licitacion') ? 'has-error' : '' }}">
								<label>ID Licitación</label>
								<input type="hidden" name="submit" value="true">
								<input type="text" name="nro_licitacion" class="form-control" value="<?=isset($_GET["nro_licitacion"]) ? $_GET["nro_licitacion"]: '' ?>">

								<?php if ($nro_licitacion){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Numero de licitacion vacio</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>


					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
								<label for="">Adjuntar licitación.</label>
								<div class="custom-file">
									<input type="file" name="archivo_licitacion" class="custom-file-input" id="customFileLangHTML" lang="es" >
									<label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
								</div>
							</div>
						</div>
					</div>

					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Presupuesto</label>
								<input type="number" name="presupuesto" class="form-control" value="<?=$_GET["presupuesto"] ?: '' ?>">

								<?php if ($presupuesto){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Presupuesto invalido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xsñ-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="exampleFormControlTextarea3">Descripción</label>
									<textarea class="form-control" name="descripcion_licitacion" rows="7"></textarea>
								</div>
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