<?php


 
namespace ContratosBitacoraShow;


/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(ModelContratos $model){


		if(isset($_GET["id"])){
            $contrato = $model->get();
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
                <a href="<?=base("/contratos/");?>">Contratos</a>
			</li>
			 
		</ol>

		<div class="card mb-3">
			<div class="card-header">

			

			<table>
			<tr>
				<td>ID CONTRATO</td>
				<td><?= $contrato["TIPO"] ."-". $contrato["ID_CONTRATO"]; ?></td>
			</tr>
			<tr>
				<td>PROVEEDOR</td>
				<td><?=$contrato["RUT_PROVEEDOR"]?></td>
			</tr>
			</table>
			<hr>
			<div class="row">
				<form method="get" class="form-horizontal" action="<?=base()."/contratos/show"?>">
					<div class="col-6">
						<label>Buscar</label>
							<div>
								<select name="codigo" class="selectpicker selectField"  placeholder='Seleccione Código' data-live-search='true'>
									<option value=""></option>
									<?php
									foreach($contrato["DETALLES"] as  $detalle) {
										$selected = $_GET["codigo"]==$detalle["CODIGO"]? 'selected' : '';
										?>
										<option value="<?= $detalle["CODIGO"];?>" <?=$selected?>>
											<?= $detalle["CODIGO"]." / ".$detalle["DESC_PROD_SOLI"];?>
										</option>
										<?php
									}
									?>
								</select>
								
							</div>
                        <input type="hidden" name="id" value="<?=$contrato['ID_CONTRATO']?>">
					</div>
					<div class="btn-group float-right">
						<?php if(!empty($_GET)){ ?> 
							<a class="btn btn-default" href="<?=base()."/contratos/show?id=".$contrato['ID_CONTRATO'];?>">Limpiar Filtros</a>
						<?php } ?>
							<button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
					</div>
				</form>
			</div>

			
            <div class="card-footer">
                <?php
                paginador($contrato['TOTAL_DETALLES'], base()."/contratos/show?id=".$_GET["id"], 10);
                ?>
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