<?php



namespace ContratosNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(\ContratosNew\ModelContratos $model){

		if(!empty($_POST)){
			//$model->execute();
		}
		$data = $model->get();

		$dataProveedores = $data[0];
		$dataLicitaciones = $data[1];
		$dataMoneda = $data[2];
		$dataCargos = $data[3];

		$proveedor_id = false;
		$selectContrato = false;
		$licitacion = false;
		$moneda_id = false;
		$precio = false;
		$cargo_id = false;
		$fecha_inicio = false;
		$fecha_termino = false;
		$fecha_aprobacion = false;
		$alerta_vencimiento = false;
		$objeto_contrato = false;
		$numero = false;
		$monto = false;
		$fecha_vencimiento = false;
		$alerta_boleta = false;


		if(sizeof($_GET)){

			if(!isset($_GET["proveedor_id"])){
				$proveedor_id = !$proveedor_id;
			}
			if(!isset($_GET["selectContrato"])){
				$selectContrato = !$selectContrato;
			}
			if(!isset($_GET["licitacion"])){
				$licitacion = !$licitacion;
			}
			if(!isset($_GET["moneda_id"])){
				$moneda_id = !$moneda_id;
			}
			if(!isset($_GET["precio"])){
				$precio = !$precio;
			}
			if(!isset($_GET["cargo_id"])){
				$cargo_id = !$cargo_id;
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
			if(!isset($_GET["alerta_vencimiento"])){
				$alerta_vencimiento = !$alerta_vencimiento;
			}
			if(!isset($_GET["objeto_contrato"])){
				$objeto_contrato = !$objeto_contrato;
			}
			// if(!isset($_GET["numero"])){
			// 	$numero = !$numero;
			// }
			if(!isset($_GET["monto"])){
				$monto = !$monto;
			}
			// if(!isset($_GET["fecha_vencimiento"])){
			// 	$fecha_vencimiento = !$fecha_vencimiento;
			// }
			// if(!isset($_GET["alerta_boleta"])){
			// 	$alerta_boleta = !$alerta_boleta;
			// }
		}

//print_r(sizeof($_GET));
		ob_start();

		?>



    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/contratos/new");?>">Contratos</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <form method="get" action="<?=base("/contratos/new");?>" >
    <div class="card">

        <div class="card-body row">
            <div class="row col-12">
                <!-- <input type="hidden" name="id" value="{{ $contrato->id }}" > -->

                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$proveedor_id ? 'has-error' : '' ;?>">
                    <label>Proveedor *</label>

                    <select class="selectpicker selectField" name='proveedor_id'  class ='form-control selectpicker selectField' placeholder='Seleccione Proveedor' data-live-search='true' id ='proveedor_id' >
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

            <div class="row col-12">
                <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4 <?=$selectContrato ? 'has-error' : '' ;?>">
                    <label>Tipo Contrato</label>
                    <select class="selectpicker selectField" placeholder='Seleccione Tipo de Contrato' name="selectContrato" id="selectContrato">
                        <option value="0">Licitación</option>
                        <option value="1">Trato Directo</option>              
                    </select>
					<?php if ($selectContrato){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$licitacion ? 'has-error' : '' ;?>" id="licitacion" >
                    <label>Licitacion *</label>
                    <select name='licitacion' class ='selectpicker selectField' placeholder='Seleccione Licitacion' data-live-search='true' id ='licitacion_id'>
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
					<?php if ($licitacion){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>            
  


            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$moneda_id ? 'has-error' : '' ;?>" >
                    <label>Moneda *</label>

                    <select name='moneda_id' class ='selectpicker selectField' placeholder='Seleccione Moneda' data-live-search='true' id ='moneda_id' >
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

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$precio ? 'has-error' : '' ;?>">
                    <label>Precio *</label>
                    <input type="number" name="precio" class="form-control" value="<?=!empty($_GET["precio"]) ? $_GET["precio"]: '' ;?>" >
					<?php if ($precio){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$cargo_id ? 'has-error' : '' ;?>">
                    <label>Cargo *</label>

                    <select name='cargo_id' class ='selectpicker selectField' placeholder='Seleccione Cargo' data-live-search='true' id ='cargo_id'>
                    	<option value=""></option>
                        <?php 
                        foreach ($dataCargos as $cargo) { 
                            if (!empty($_GET["cargo_id"]) && $_GET["cargo_id"]){
                                ?>
                                <option selected="true" value="<?= $cargo["ID_CARGO"];?>"><?= $cargo["NOMBRE"];?></option>
                                <?php
                            }else{
                                ?>
                                <option value="<?= $cargo["ID_CARGO"];?>"><?= $cargo["NOMBRE"];?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
					<?php if ($cargo_id){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>

                       
            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$fecha_inicio ? 'has-error' : '' ;?>">
                    <label>Fecha de inicio *</label>
                    
                    <input type="date" name="fecha_inicio" class="form-control" value="<?=!empty($_GET["fecha_inicio"]) ? $_GET["fecha_inicio"]: '' ;?>">
					<?php if ($fecha_inicio){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$fecha_termino ? 'has-error' : '' ;?>">
                    <label>Fecha de termino *</label>
                    
                    <input type="date" name="fecha_termino" class="form-control" value="<?=!empty($_GET["fecha_termino"]) ? $_GET["fecha_termino"]: '' ;?>">
					<?php if ($fecha_termino){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$fecha_aprobacion ? 'has-error' : '' ;?>">
                    <label>Fecha de aprobación *</label>
                    
                    <input type="date" name="fecha_aprobacion" class="form-control" value="<?=!empty($_GET["fecha_aprobacion"]) ? $_GET["fecha_aprobacion"]: '' ;?>">
					<?php if ($fecha_aprobacion){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$alerta_vencimiento ? 'has-error' : '' ;?>">
                    <label>Alerta de vencimiento</label>
                    
                    <input type="date" name="alerta_vencimiento" class="form-control" value="<?=!empty($_GET["alerta_vencimiento"]) ? $_GET["alerta_vencimiento"]: '' ;?>">
					<?php if ($alerta_vencimiento){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div>
            </div>
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

            <!-- {{-- <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('objeto_contrato') ? 'has-error' : '' }}">
                        <label for="exampleFormControlTextarea3">Objeto del contrato *</label>
                        <textarea class="form-control" name="objeto_contrato" rows="3" value="{{ $contrato->objeto_contrato ?: old('objeto_contrato') }}"></textarea>
                      </div>
					<?php if ($objeto_contrato){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: Numero de licitacion vacio</strong>
					</span>
					<?php } ?>
                </div> --}} -->

                

                <div class="row col-12" name="Agregar">
                    <!-- <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$numero ? 'has-error' : '' ;?>">
                            <label>N° de boleta *</label>
                            <input type="text" name="numero" class="form-control" value="<?=!empty($_GET["numero"]) ? $_GET["numero"]: '' ;?>" >
							<?php if ($numero){ ?>
							<span class="help-block text-danger"> 
								<strong>Error: Numero de licitacion vacio</strong>
							</span>
							<?php } ?>
                        </div>
                    </div> -->

                    <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$monto ? 'has-error' : '' ;?>">
                            <label>Monto *</label> <!--Sección que guarda el monto del contrato   -->
                            <input type="number" name="monto" class="form-control" value="<?=!empty($_GET["monto"]) ? $_GET["monto"]: '' ;?>">
							<?php if ($monto){ ?>
							<span class="help-block text-danger"> 
								<strong>Error: Numero de licitacion vacio</strong>
							</span>
							<?php } ?>
                        </div>
                    </div>

                    <!-- <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$fecha_vencimiento ? 'has-error' : '' ;?>">
                            <label>Fecha de vencimiento de boleta *</label>
                            
                            <input type="date" name="fecha_vencimiento" class="form-control" value="<?=!empty($_GET["fecha_vencimiento"]) ? $_GET["fecha_vencimiento"]: '' ;?>">
							<?php if ($fecha_vencimiento){ ?>
							<span class="help-block text-danger"> 
								<strong>Error: Numero de licitacion vacio</strong>
							</span>
							<?php } ?>
                        </div>
                    </div> -->

                    <!-- <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$proveedor_id ? 'has-error' : '' ;?>">
                            <label>Alerta de vencimiento de boleta</label>
                            
                            <input type="date" name="alerta_boleta" class="form-control" value="<?=!empty($_GET["alerta_boleta"]) ? $_GET["alerta_boleta"]: '' ;?>">
							<?php if ($alerta_boleta){ ?>
							<span class="help-block text-danger"> 
								<strong>Error: Numero de licitacion vacio</strong>
							</span>
							<?php } ?>
                        </div>
                    </div> -->
                </div>

                <!-- <input type="hidden" name="boleta_id" class="form-control" value="{{ $contrato->boleta_id }}"> -->

        </div>

        <div class="card-footer">
        <div class="row">
            <div class="col-sm-8">
            <button type="submit" class="btn-primary btn rounded" ><i class="icon-floppy-disk"></i> Guardar</button>
            </div>
        </div>
        </div>

    </div>
  </form>


<script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js">
</script>


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

<script>
    
    $(function() {
    $('#licitacion').show(); 
    $('#selectContrato').change(function(){
        if($('#selectContrato').val() == '0') {
            $('#licitacion').show(); 
        } else {
            $('#licitacion').hide(); 
        } 
    });
});
</script> 
<hr>

 





		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}