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

		if(isset($_GET["id"])){
            $registroEdit = $model->get();
        }

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
				<a href="<?=base();?>/licitaciones" class="encabezado">Licitaciones</a>
			</li>
			<!-- <li class="breadcrumb-item active">Mantenedor</li> -->
		</ol>

        <?=feedback2(); ?>

		<div class="card mb-3">
			<div class="card-header">
				<form method="post" class="form-horizontal" action="<?=base();?>/licitaciones/new" enctype="multipart/form-data">


                    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 ">
                        <label>ID Licitación</label>
                        <input type="text" name="nro_licitacion" class="form-control"
                               value="<?=$registroEdit['NRO_LICITACION'] ?? $_GET['nro_licitacion'] ?? ''?>" >

                    </div>



                    <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
                        <label for="">Adjuntar licitación.</label>
                        <div class="custom-file">
                            <input type="file" name="archivo_licitacion" class="custom-file-input" id="customFileLangHTML" lang="es" >
                            <label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
                        </div>
                    </div>


                    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                        <label>Presupuesto</label>
                        <input type="number" name="presupuesto" class="form-control"
                               value="<?=$registroEdit['PRESUPUESTO'] ?? $_GET['presupuesto']  ?? '' ?>">

                    </div>


                    <div class="form-group has-feedback col-xs-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea3">Descripción</label>
                            <textarea class="form-control" name="descripcion_licitacion" rows="7"><?=$registroEdit['DETALLE']  ?? $_GET['descripcion_licitacion'] ?? '' ?></textarea>
                        </div>
                    </div>
					<br>

					<div class="card-footer">
						<div class="row">
							<div class="col-sm-8">
                                <input type="hidden" name="submit" value="true">
                                <input type="hidden" name="id" value="<?=$registroEdit['NRO_LICITACION']?>">
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