<?php


 
namespace ContratosShow;


/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(ModelContratos $model){


		if(isset($_GET["id"])){
            $contrato = $model->get();
		}
		
		$data = $model->get();

        //Forman la tabla
		$listado = $data[0];



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
                <a href="<?=base("/contratos/");?>">Contratos</a>
			</li>
			 
		</ol>

		<div class="card mb-3">
			<div class="card-header">
			<div class="table-responsive table-sm -md -lg -x">
				<table class="table table-bordered"  class="table-sm w-25" id="dataBitacoras" width=100% cellspacing="0">
					<thead>
						<tr>
							<th>Código</th>
							<th>DESC_PROD_SOLI</th>
							<th>CANTIDAD TOTAL</th>
							<th>PRECIO_U_BRUTO</th>
							<th>GRUPO</th>
							<th>PRESENTACION_PROD_SOLI</th>
							<th>F_F</th>
							<th>DESC_TEC_PROD_OFERTADO</th>
							<th>U_ENTREGA_OFERENTE</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($listado as $index => $contrato) {
							// foreach ($documentos as $documento) {
							?>
						<?php foreach($contrato["DETALLES"] as  $detalle){?>
								<tr>
								
									<td> <?= $detalle["CODIGO"]; ?></td>
									<td> <?= $detalle["DESC_PROD_SOLI"]; ?></td>
									<td> <?= $detalle["CANTIDAD_TOTAL"]; ?></td>
									<td> <?= $detalle["PRECIO_U_BRUTO"]; ?></td>
									<td> <?= $detalle["GRUPO"]; ?></td>
									<td> <?= $detalle["PRESENTACION_PROD_SOLI"]; ?></td>
									<td> <?= $detalle["F_F"]; ?></td>
									<td> <?= $detalle["DESC_TEC_PROD_OFERTADO"]; ?></td>
									<td> <?= $detalle["U_ENTREGA_OFERENTE"]; ?></td>
								</tr>
						<?php }?>
						
						<?php
                        // }
                    }
                    ?>
					</tbody>
				</table>
                </div>
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




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}