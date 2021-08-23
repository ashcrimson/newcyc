<?php


 
namespace ContratosShow;


/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(ModelContratos $model){


		if(isset($_GET["id"])){
			$contrato = $model->get();
			// $suma = $model->suma();
		}




        $queryString = $_SERVER['QUERY_STRING'] ?? '';

        $id = $_GET['id'] ?? 0;

        if($id){
            $search= 'id='.$id.'&';
            $queryString = str_replace($search,'?',$queryString);
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
				<td>ID MERCADO PUBLICO</td>
				<td><?= $contrato["ID_MERCADO_PUBLICO"]; ?></td>
			</tr>
			<tr>
				<td>PROVEEDOR</td>
				<td><?=$contrato["RUT_PROVEEDOR"]?></td>
			</tr>
			</table>
			<hr>
			<div class="row">
				<form method="get" class="form-horizontal" action="<?=base()."/contratos/show"?>">
					<div class="col-12" style="width:600px;">
						<label>Buscar</label>
							
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
							<!-- <th>SUMA</th> -->
						</tr>
					</thead>
					<tbody>  
 
					
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
									<!-- <td><?= $suma ?></td> -->
									
								</tr>
						<?php }?>
						
							
					</tbody>
				</table>
				
                </div>
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

<!-- {{-- Script para mostrar nombre archivo en el select --}} -->
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}