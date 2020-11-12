<?php



namespace LicitacionesList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewLicitaciones {
	
	public function output(\LicitacionesList\ModelLicitaciones $model){

		$data = $model->get();

		$listaLicitaciones = $data[0];
		$numerosLicitaciones = $data[1];
		$totales = $data[2];
		$documentos = $data[3];

		ob_start();

		?>


		<script lang="javascript" src="./assets/assets/frontend/js/xlsx.full.min.js"></script>
		<script lang="javascript" src="./assets/assets/frontend/js/FileSaver.js"></script>
		<script lang="javascript" src="./assets/assets/frontend/js/xlsx.core.min.js"></script>


		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="./licitaciones">Licitaciones</a>
			</li>        
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<form method="get" class="form-horizontal" action="./licitaciones">

					<div class="row"> 
						<div class="col-3">
							<label>ID Licitacion</label>
							<div>
								<select name="nro_licitacion" class="selectpicker selectField" placeholder="Seleccione ID Licitación" data-live-search='true'>
									<option value=""></option>
									<?php 
									foreach ($numerosLicitaciones as $licitaciones) { 
										if (!empty($_GET["nro_licitacion"]) && $_GET["nro_licitacion"] == $licitaciones["NRO_LICITACION"]){
											?>
											<option selected="true" value="<?= $licitaciones["NRO_LICITACION"];?>"><?= $licitaciones["NRO_LICITACION"];?></option>
											<?php
										}else{
											?>
											<option value="<?= $licitaciones["NRO_LICITACION"];?>"><?= $licitaciones["NRO_LICITACION"];?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="btn-group float-right ml-3">
						<a href="<?=base("/licitaciones/new/");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>         
					</div>

					<div class="btn-group float-right">
						<?php if(!empty($_GET)){ ?> 
						<a class="btn btn-default" href="./licitaciones">Limpiar Filtros</a>
						<?php } ?>
						<button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
					</div>

					<div>
						<i class="fas fa-table"> Registros</i>
					</div>

					<div class="card-body">
<!-- 						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status')}}
						</div>
						@endif  
 -->
					</div>
				</form>
			</div>

			<div class="card-body">
<!-- 				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status')}}
				</div>

				@endif -->
				<div class="table-responsive table-sm -md -lg -x">
					<table class="table table-bordered"  class="table-sm w-25" id="dataLicitaciones" width=100% cellspacing="0">
						<thead>
							<tr>
								<th>ID Licitación</th>
								<th>Presupuesto</th>
								<th>Descripción</th>
								<th>Adjunto</th>
								<!-- {{-- <th>Acción</th> --}} -->
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach ($listaLicitaciones as $licitaciones) {
								// foreach ($documentos as $documento) {	
								?>
							<tr>
								<td> <?= $licitaciones["NRO_LICITACION"]; ?></td>
								<td> <?= $licitaciones["PRESUPUESTO"]; ?></td>
								<td> <?= $licitaciones["DETALLE"]; ?></td>
								<td>
									<a href="<?= base()."/archivo/download?id=".$licitaciones['NRO_DOCUMENTO'] ?>" target="_blank">
										<?= $licitaciones["NOMBRE_DOCUMENTO"] ?>
									</a>
								</td>

								
							</tr>
								<?php
							// }
						}
							?>
						</tbody>
					</table>
				</div>


			</div>


			<div class="card-footer">

				<?php

				paginador($totales, "./licitaciones", 10);

				?>
				
			</div>
		</div>






		<script src="./assets/assets/frontend/js/jquery-3.3.1.js"></script>
		<script src="./assets/assets/frontend/js/selectize.js"></script>
		<script>
			$('.selectField').selectize({
				create: false,
				sortField: {
					field: 'text',
					direction: 'asc'
				},
				dropdownParent: 'body'
			});

			$('.selectMulti').selectize({
				maxItems: 3
			});
		</script>





		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}