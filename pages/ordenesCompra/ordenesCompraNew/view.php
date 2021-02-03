<?php

 

namespace OrdenCompraNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */ 
class ViewOrdenCompra {
	
	public function output(\OrdenCompraNew\ModelOrdenCompra $model){

		if(!empty($_POST)){
			$model->execute();
        }

        if(isset($_GET["nro_orden_compra"])){
			$registroEdit = $model->get();
			
        }
        
        $data = $model->get();

        $dataContratos = $model->getContratos();
        $dataDetalleContratos = $model->getDetalleContrato();
        $dataDetalleContratos2 = $model->getDetalleContrato2();
        $dataDetalleContratos3 = $model->getDetalleContrato3();
        $dataDetalleContratos4 = $model->getDetalleContrato4();
        $dataDetalleContratos5 = $model->getDetalleContrato5();
        $dataDetalleContratos6 = $model->getDetalleContrato6();
        $dataDetalleContratos7 = $model->getDetalleContrato7();
        $dataDetalleContratos8 = $model->getDetalleContrato8();
        $dataDetalleContratos9 = $model->getDetalleContrato9();
        $dataDetalleContratos10 = $model->getDetalleContrato10();
        $dataDetalleContratos11 = $model->getDetalleContrato11();
        $dataDetalleContratos12 = $model->getDetalleContrato12();

		$id_contrato = false;
        $nro_orden_compra = false;
        $archivo_orden_compra = false;
        $estado = false;
        $total = false;
		


		if(sizeof($_GET)){
			if(!isset($_GET["id_contrato"])){
				$id_contrato = !$id_contrato;
			}
			if(!isset($_GET["nro_orden_compra"])){
				$nro_orden_compra = !$nro_orden_compra;
            }
            if(!isset($_GET["estado"])){
				$estado = !$estado;
            }
            if(!isset($_GET["archivo_orden_compra"])){
				$archivo_orden_compra = !$archivo_orden_compra;
			}
            if(!isset($_GET["total"])){
				$total = !$total;
            }
            if(!isset($_GET["fecha_envio"])){
				$fecha_envio = !$total;
			}
			
		}

//print_r(sizeof($_GET));
		ob_start();

		?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=base("/ordenCompra");?>">Orden de Compra</a>
            </li>
            <!-- <li class="breadcrumb-item active">Mantenedor</li> -->
        </ol>

        <!-- DataTables -->
        <div class="card mb-3">
            <div class="card-header">
                
                <form method="post" class="form-horizontal" action="<?=base();?>/ordenCompra/new" enctype="multipart/form-data">
                <div class="container">
                    <?php feedback();?>
                    <div class="row col-12">
                    <input type="hidden" name="id" value="<?=isset($_GET["nro_orden_compra"]) ? $_GET["nro_orden_compra"]: "" ?>" >
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$selectContrato ? 'has-error' : '' ;?>">
                            <label>ID Contrato</label>
                            <input type="hidden" name="submit" value="true">
                            <select class="selectpicker " placeholder='Seleccione Tipo de Contrato' name="id_contrato" id="selectContrato" value="<?=isset($_GET["id_contrato"]) ? $_GET["id_contrato"]: (isset($registroEdit["ID_CONTRATO"]) ? $registroEdit["ID_CONTRATO"] : "") ?>">
                                <?php 
                                foreach ($dataContratos as $contrato) {
                                    $selected = $registroEdit['ID_CONTRATO']==$contrato["ID_CONTRATO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $contrato["ID_CONTRATO"];?>" <?=$selected?> ><?=$contrato["TIPO"] ."-". $contrato["ID_CONTRATO"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            
                        </div>
                    </div>
                </div>
					
                <div class="container">
                    <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>                            
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion2"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos2 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion3"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos3 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion4"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos4 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion5"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos5 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion6"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos6 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion7"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos7 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion8"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos8 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion9"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos9 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion10"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos10 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion11"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos11 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$detalle_contrato ? 'has-error' : '' ;?>" id="licitacion12"  >
                            <label>Detalle Contrato</label>
                            <select name='detalle_contrato' class ='selectpicker selectField' placeholder='Seleccione Detalle' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["detalle_contrato"]) ? $_GET["detalle_contrato"]: (isset($registroEdit["CODIGO"]) ? $registroEdit["CODIGO"] : "") ?>">
                                <option value=""></option>
                                <?php 
                                foreach ($dataDetalleContratos12 as $detalle) {
                                    $selected = $registroEdit['CODIGO']==$detalle["CODIGO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $detalle["CODIGO"];?>" <?=$selected?> ><?=$detalle["CODIGO"] ."-". $detalle["DESC_PROD_SOLI"];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>



                    </div>
                </div>


                    

                <!-- CANTIDAD -->

                <div class="container">
                    <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('cantidad') ? 'has-error' : '' }}">
                            <label>Cantidad</label>
                            
                            <input type="number" name="cantidad" class="form-control" required
                            value="<?= $_GET["cantidad"] ?? $registroEdit['CANTIDAD'] ?>" min="0" >

                            
                        </div>
                    </div>
                </div>  

                    <!-- FIN CANTIDAD  -->

                        <div class="container">
                            <div class="row col 12">
                                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$nro_orden_compra ? 'has-error' : '' ;?>" id="nro_orden_compra">
                                    <label>Número Orden de Compra * </label>

                                    <!-- <input type="text" name="numeroOrdenCompra"  class="form-control" value="{{ $ordenCompraData->numeroOrdenCompra ?: old('numeroOrdenCompra') }}"> -->
                                    <input type="text" name="nro_orden_compra"  class="form-control" required
                                    value="<?= $_GET["nro_orden_compra"] ?? $registroEdit['NRO_ORDEN_COMPRA'] ?>">


                                            </div>
                                        </div>
                            </div> 
 
                            <div class="container">
                                <div class="row col-12">
                                    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('fecha_envio') ? 'has-error' : '' }}">
                                        <label>Fecha de Envío</label>
                                        
                                        <input type="date" name="fecha_envio" class="form-control" 
                                        value="<?=$_GET["fecha_envio"] ??  fechaEn($registroEdit['FECHA_ENVIO']) ?? ''?>" required>

                                        <?php if ($fecha_envio){ ?>
                                        <span class="help-block text-danger"> 
                                            <strong>Error: fecha_envio vacio</strong>
                                        </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div> 

                                    <div class="container">
                                        <div class="row col-12">
                                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('total') ? 'has-error' : '' }}">
                                                <label>Total</label>
                                                
                                                <input type="text" name="total" class="form-control" required
                                                value="<?= $_GET["total"] ?? $registroEdit['TOTAL'] ?>">

                                                
                                            </div>
                                        </div>
                                    </div>   
  

                                    <div class="container">
                                        <div class="row col-12">
                                            <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4 {{ $errors->has('estado') ? 'has-error' : ''}}">
                                                <label>Estado *</label>
                                                <select class="selectpicker selectField" placeholder='Seleccione Estado' name="estado" id="estado" value="<?=isset($_GET["estado"]) ? $_GET["estado"]: (isset($registroEdit["ESTADO"]) ? $registroEdit["ESTADO"] : "") ?>">
                                                    <option value="Aceptado" <?=$registroEdit['ESTADO']=='Aceptado' ? 'selected' : ''?>>Aceptado</option>
                                                    <option value="Pendiente" <?=$registroEdit['ESTADO']=='Pendiente' ? 'selected' : ''?>>Pendiente</option>
                                                    <option value="Recepcion Conforme" <?=$registroEdit['ESTADO']=='Recepcion Conforme' ? 'selected' : ''?>>Recepcion Conforme</option>

                                                </select>
                                                

                                            </div>
                                        </div>
                                    </div>


                                    <div class="container">
                                        <div class="row col-12">
                                            <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
                                                <label for="">Adjuntar Orden de Compra</label>
                                                <div class="custom-file">
                                                    <input type="file" name="archivo_orden_compra" class="custom-file-input" id="customFileLangHTML" lang="es" >
                                                    <label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    


                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <button type="submit" class="btn-primary btn rounded" name="submit" value="1" ><i class="icon-floppy-disk"></i> Guardar</button>
                                            </div>
                                        </div>
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

            $('#licitacion').hide(); 
            $('#licitacion2').hide();
            $('#licitacion3').hide(); 
            $('#licitacion4').hide();
            $('#licitacion5').hide();
            $('#licitacion6').hide();
            $('#licitacion7').hide();
            $('#licitacion8').hide();
            $('#licitacion9').hide();
            $('#licitacion10').hide();
            $('#licitacion11').hide();
            $('#licitacion12').hide();
                
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
					if(value == "1"){
						$('#licitacion').show();
                        $('#licitacion2').hide();
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "2") {
                        $('#licitacion').hide(); 
						$('#licitacion2').show();
                        $('#licitacion3').hide();
                        $('#licitacion4').hide(); 
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "3") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').show();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "4") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').show();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "5") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').show();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "6") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').show();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "7") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').show();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "8") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').show();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "9") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').show();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "10") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').show();
                        $('#licitacion11').hide();
                        $('#licitacion12').hide();
					} else if(value == "11") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').show();
                        $('#licitacion12').hide();
					} else if(value == "12") {
                        $('#licitacion').hide(); 
						$('#licitacion2').hide(); 
                        $('#licitacion3').hide();
                        $('#licitacion4').hide();
                        $('#licitacion5').hide();
                        $('#licitacion6').hide();
                        $('#licitacion7').hide();
                        $('#licitacion8').hide();
                        $('#licitacion9').hide();
                        $('#licitacion10').hide();
                        $('#licitacion11').hide();
                        $('#licitacion12').show();
					}
                    
					// console.log("Cambio", value);
				}
			});
		    </script> 

                

                <?php

                $output = ob_get_contents();
                ob_end_clean();

                return $output;
//		return "";

            }
        }