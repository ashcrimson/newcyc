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
		if(isset($_GET["id"])){
            $data = $model->get()[0];
        }
        
        $data = $model->get();

		$dataProveedores = $data[0];
		$dataLicitaciones = $data[1];
		$dataMoneda = $data[2];
		$dataCargos = $data[3];

		$id_contrato = false;
		$licitacion = false;
		$proveedor_id = false;
        $id_area = false;
        $id_admin = false;
        $moneda_id = false;
        $selectContrato = false;
        $monto = false;
        $estado_alerta = false;
        $fecha_inicio = false;
        $fecha_termino = false;
        $fecha_aprobacion = false;
        $fecha_alert = false;
        $fecha_creacion = false;
        $fecha_actualizacion = false;
		$fecha_eliminacion = false;
		


		if(sizeof($_GET)){
			if(!isset($_GET["id_contrato"])){
				$id_contrato = !$id_contrato;
			}
			if(!isset($_GET["licitacion"])){
				$nro_licitacion = !$licitacion;;
			}
			if(!isset($_GET["rut_proveedor"])){
				$rut_proveedor = !$rut_proveedor;
			}
			if(!isset($_GET["id_area"])){
				$id_area = !$id_area;
            }
            if(!isset($_GET["id_cargo"])){
				$id_admin = !$id_admin;
            }
            if(!isset($_GET["moneda_id"])){
				$moneda_id = !$moneda_id;
            }
            if(!isset($_GET["selectContrato"])){
				$selectContrato = !$selectContrato;
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
            if(!isset($_GET["fecha_alert"])){
				$fecha_alert = !$fecha_alert;
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
			 
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<form method="post" class="form-horizontal" action="<?=base();?>/contratos/new" enctype="multipart/form-data">
					
					<div class="container">
					<?php feedback();?>
						<div class="row col-12">
							<div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4 <?=$selectContrato ? 'has-error' : '' ;?>">
								<label>Tipo Contrato</label>
								<input type="hidden" name="submit" value="true">
								<select class="selectpicker " placeholder='Seleccione Tipo de Contrato' name="selectContrato" id="selectContrato" value="<?=isset($_GET["selectContrato"]) ? $_GET["selectContrato"]: (isset($data["TIPO"]) ? $data["TIPO"] : "") ?>">
									<option value="lc">Licitación</option>
									<option value="td">Trato Directo</option>              
								</select>
								<?php if ($selectContrato){ ?>
								<span class="help-block text-danger"> 
									<strong>Tipo de contrato vacío</strong>
								</span>
								<?php } ?>
							</div>
            			</div>
					</div>
					
			

					<div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$licitacion ? 'has-error' : '' ;?>" id="licitacion"  >
								<label>Licitacion *</label>
								<select name='licitacion' class ='selectpicker selectField' placeholder='Seleccione Licitacion' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["licitacion"]) ? $_GET["licitacion"]: (isset($data["NRO_LICITACION"]) ? $data["NRO_LICITACION"] : "") ?>">
									<option value=""></option>
									<?php 
									foreach ($dataLicitaciones as $licitacionn) { 
										if (!empty($_GET["licitacion"]) && $_GET["licitacion"]){
											?>
											<option selected="true" value="<?= $licitacionn["NRO_LICITACION"];?>"><?= $licitacionn["NRO_LICITACION"];?></option>
											<?php
										}else{
											?>
											<option value="<?= $licitacionn["NRO_LICITACION"];?>"><?= $licitacionn["NRO_LICITACION"];?></option>
											<?php
										}
									}
									?>
								</select>
								<?php if (!isset($licitacion)){ ?>
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
								<label for="">Adjuntar contrato.</label>
								<div class="custom-file">
									<input type="file" name="archivo_contrato" class="custom-file-input" id="customFileLangHTML" lang="es" required value="<?=isset($_GET["archivo_contrato"]) ? $_GET["archivo_contrato"]: (isset($data["CODIGO"]) ? $data["NRO_DOCUMENTO"] : "") ?>">
									<label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
								</div>
							</div>
						</div>
					</div>

                    <div class="container">
					<div class="row col-12">
                <!-- <input type="hidden" name="id" value="{{ $contrato->id }}" > -->

                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$proveedor_id ? 'has-error' : '' ;?>">
                    <label>Proveedor *</label>

                    <select class="selectpicker selectField" name='proveedor_id'  class ='form-control selectpicker selectField' placeholder='Seleccione Proveedor' data-live-search='true' id ='proveedor_id' value="<?=isset($_GET["proveedor_id"]) ? $_GET["proveedor_id"]: (isset($data["RUT_PROVEEDOR"]) ? $data["RUT_PROVEEDOR"] : "") ?>">
                    	<option value=""></option>
                        <?php 
                        foreach ($dataProveedores as $proveedor) { 
                            if (!empty($_GET["proveedor_id"]) && $_GET["proveedor_id"]){
                                ?>
                                <option selected="true" value="<?= $proveedor["RUT_PROVEEDOR"];?>"><?= $proveedor["RUT_PROVEEDOR"];?></option>
                                <?php
                            }else{
                                ?>
                                <option value="<?= $proveedor["RUT_PROVEEDOR"];?>"><?= $proveedor["RUT_PROVEEDOR"];?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
					<?php if ($proveedor_id){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>
					</div>

                    

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 ">
								<label>Cargo</label>
								<select class="selectpicker selectField" name='id_admin'  class ='form-control selectpicker selectField' placeholder='Seleccione Cargo' data-live-search='true' id ='id_admin' value="<?=isset($_GET["id_admin"]) ? $_GET["id_admin"]: (isset($data["ID_CARGO"]) ? $data["ID_CARGO"] : "") ?>">
									<option value=""></option>
									<?php 
									foreach ($dataCargos as $cargo) { 
										if (!empty($_GET["cargo_id"]) && $_GET["cargo_id"]){
											?>
											<option selected="true" value="<?= $cargo["NOMBRE"];?>"><?= $cargo["NOMBRE"];?></option>
											<?php
										}else{
											?>
											<option value="<?= $cargo["NOMBRE"];?>"><?= $cargo["NOMBRE"];?></option>
											<?php
										}
									}
									?>
								</select>
								<?php if ($id_admin){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Cargo inválido.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
						<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$moneda_id ? 'has-error' : '' ;?>" >
                    <label>Moneda *</label>

                    <select name='moneda_id' class ='selectpicker selectField' placeholder='Seleccione Moneda' data-live-search='true' id ='moneda_id' value="<?=isset($_GET["moneda_id"]) ? $_GET["moneda_id"]: (isset($data["ID_MONEDA"]) ? $data["ID_MONEDA"] : "") ?>">
                    	<option value=""></option>
                        <?php 
                        foreach ($dataMoneda as $moneda) { 
                            if (!empty($_GET["moneda_id"]) && $_GET["moneda_id"]){
                                ?>
                                <option selected="true" value="<?= $moneda["NOMBRE"];?>"><?= $moneda["NOMBRE"];?></option>
                                <?php
                            }else{
                                ?>
                                <option value="<?= $moneda["NOMBRE"];?>"><?= $moneda["NOMBRE"];?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
					<?php if ($moneda_id){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
						</div>
					</div>

            

                    <div class="container">
						<div class="row col-12">
						<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$monto ? 'has-error' : '' ;?>">
                            <label>Monto *</label> <!--Sección que guarda el monto del contrato   -->
                            <!-- <input type="number" name="monto" class="form-control" value="<?=!empty($_GET["monto"]) ? $_GET["monto"]: '' ;?>"> -->
							<input type="number" class="form-control" name="monto" onchange="setTwoNumberDecimal" min="0" max="100000000000000" step="0.25" value="0.00" />
							<?php if ($monto){ ?>0
							<span class="help-block text-danger"> 
								<strong>Error: Numero de licitacion vacio</strong>
							</span>
							<?php } ?>
                        </div>
						</div>
					</div>

                   

                    <div class="container">
						<div class="row col-12">
						<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$fecha_inicio ? 'has-error' : '' ;?>" >
                    <label>Fecha Inicio Contrato*</label>
                    
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?=!empty($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"]: '' ;?>" min="<?php echo date("Y-m-d"); ?>">
					<?php if ($fecha_inicio){ ?>
					<span class="help-block text-danger"> 
						<strong>Fecha incorrecta</strong>
					</span>
					<?php } ?>
                </div>
						</div>
					</div>

                    <div class="container">
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
								<label>Fecha Término Contrato</label>
								<input type="date" name="fecha_termino" id="fecha_termino" class="form-control" value="<?=$_GET["fecha_termino"] ?: '' ?>" oninput="fecha();">
								<div class="alert alert-danger" role="alert" id="error_fecha" style="display:none;">
								"La fecha de término no puede ser menor a la fecha de inicio."
								</div>
								
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
								<label>Resolución Aprueba</label>
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
								<label>Fecha Alerta Término Contrato</label>
								<input type="date" name="fecha_alert" class="form-control" value="<?=$_GET["fecha_alert"] ?: '' ?>">

								<?php if ($fecha_alert){ ?>
								<span class="help-block text-danger"> 
									<strong>Error: Fecha Aprobación inválida.</strong>
								</span>
								<?php } ?>
							</div>
						</div>
					</div>

                
                    <div class="container">
						<div class="row col-12">
						<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$objeto_contrato ? 'has-error' : '' ;?>">
                    <label>Objeto del contrato *</label>
                    
                    <input type="text" name="objeto_contrato" class="form-control" value="<?=!empty($_GET["objeto_contrato"]) ? $_GET["objeto_contrato"]: '' ;?>" >
					<?php if ($objeto_contrato){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
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
		
			$('#selectContrato').selectize({

				create: false,
				sortField: {
					field: 'text',
					direction: 'asc'
				},
				dropdownParent: 'body',
				onChange: function(value) {
					if(value == "td"){
						$('#licitacion').hide(); 
					} else {
						$('#licitacion').show(); 
					}
					// console.log("Cambio", value);
				}
			});
		</script> 





<hr>

<script>
function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
}
</script>

<script>
function fecha(){
	var fecha_inicio = document.getElementById("fecha_inicio").value;
	var fecha_termino = document.getElementById("fecha_termino").value;

	if (fecha_inicio >= fecha_termino) {
    	document.getElementById("error_fecha").style.display = "block";
  	} else {
    	document.getElementById("error_fecha").style.display = "none";
	  }

}
</script>








		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}