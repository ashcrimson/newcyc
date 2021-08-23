<?php
 

 
namespace ContratosBitacoraShow;


/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(ModelContratos $model){

        $contrato = $model->get();



		ob_start();

		$queryString = $_SERVER['QUERY_STRING'] ?? '';

        $id = $_GET['id'] ?? 0;

		if($id){
		    $search= 'id='.$id.'&';
            $queryString = str_replace($search,'?',$queryString);
        }


		?>




		<!-- Habilitar nombre de archivo adjunto-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

		<?php
		//valida si es admin
		?>
		<!-- Breadcrumbs-->

		<link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
                <a href="<?=base("/contratos/").$queryString;?>">Contratos</a>
			</li>
			 
		</ol>

        <?= feedback2()?>


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
			<!-- <div class="row">
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
			</div> -->
			<hr>
			<form method="post" action="<?=base();?>/contratos/bitacora/store" enctype="multipart/form-data">
				<div class="form-row">
					<div class="form-group col-12">
						<label for="">Adjuntar archivo bitácora.</label>
						<div class="custom-file">
							<input type="file" name="archivo_bitacora" class="custom-file-input" id="customFileLangHTML" lang="es">
							<label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
						</div>
					</div>
					<div class="form-group col-12">
						<label>Comentarios *</label>
						<textarea type="text" name="glosa" class="form-control" value="" ></textarea>
						<input type="hidden" name="id_contrato" value="<?=$contrato['ID_CONTRATO']?>">
						<input type="hidden" name="save_bitacora" value="1">
					</div>
				</div>

				<div>
					
					<button type="submit" class="btn btn-success">
						<i class="fa fa-floppy-o"></i>
						Guardar
					</button>
				</div>
			</form>

            <div class="table-responsive table-sm -md -lg -x tabla-bitacora">
                <table class="table table-bordered"  class="table-sm w-25" id="dataBitacoras" width=100% cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Glosa</th>
                        <th>Documento</th>
						<th>Ingresada por</th>
						<!-- <th>Actualizado por</th> -->

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($contrato['BITACORAS'] as $bitacora){?>
                        <tr>
                            <td> <?= $bitacora["FECHA_CREACION"]; ?></td>
                            <td> <?= $bitacora["GLOSA"]; ?></td>

                            <td>
                                <a href="<?= base()."/archivo/download?id=".$bitacora['NRO_DOCUMENTO'] ?>" target="_blank">
                                    <?= $bitacora["DOCUMENTO"] ?>
                                </a>
                            </td>
							<td><?= $bitacora["USUARIO_CREA"]; ?></td>
							<!-- <td><?= $bitacora["USUARIO_ACTUALIZA"]; ?></td> -->



                        </tr>
                    <?php }?>


                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <?php
                paginador($contrato['TOTAL_DETALLES'], base()."/contratos/bitacora/show?id=".$_GET["id"], 10);
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

		<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

		<script>
		$(document).ready( function () {
			$('#myTable').DataTable();
		} );
		
		</script>




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}