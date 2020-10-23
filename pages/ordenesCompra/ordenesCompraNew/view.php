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
        
        $data = $model->get();

		$dataContratos = $data[0];

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
				$estado = !$total;
			}
			
		}

//print_r(sizeof($_GET));
		ob_start();

		?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=base("/ordenCompra/new");?>">Orden de Compra</a>
            </li>
            <!-- <li class="breadcrumb-item active">Mantenedor</li> -->
        </ol>

        <!-- DataTables -->
        <div class="card mb-3">
            <div class="card-header">
                
                <form method="post" class="form-horizontal" action="<?=base();?>/ordenCompra/new" enctype="multipart/form-data">
                    
                    <div class="container">
                        <div class="row col-12">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$id_contrato ? 'has-error' : '' ;?>" >
                        <label>ID Contrato *</label>
                        <select name='id_contrato' class ='selectpicker selectField' placeholder='Seleccione Contrato' data-live-search='true' id ='id_contrato'>
                            <option value=""></option>
                            <?php 
                            foreach ($dataContratos as $contrato) { 
                                if (!empty($_GET["id_contrato"]) && $_GET["id_contrato"]){
                                    ?>
                                    <option selected="true" value="<?= $contrato["ID_CONTRATO"];?>"><?= $contrato["ID_CONTRATO"];?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?= $contrato["ID_CONTRATO"];?>"><?= $contrato["ID_CONTRATO"];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        </div>
                        </div>
                    </div>                        

                        <div class="container">
                            <div class="row col 12">
                                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$nro_orden_compra ? 'has-error' : '' ;?>" id="nro_orden_compra">
                                    <label>Número Orden de Compra * </label>

                                    <!-- <input type="text" name="numeroOrdenCompra"  class="form-control" value="{{ $ordenCompraData->numeroOrdenCompra ?: old('numeroOrdenCompra') }}"> -->
                                    <input type="text" name="nro_orden_compra"  class="form-control" >

<!--                                    
                        <?php if ($nro_orden_compra){ ?>
                            <span class="help-block text-danger"> 
                                <strong>Error: Numero orden de compra</strong>
                            </span>
                        <?php } ?>

                            </div>
                        </div>

                    </div>


                    <div class="container">
                        <div class="row col 12">
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg4 {{ $errors->has('fecha_envio') ? 'has-error' : ''}}">
                                <label>Fecha de Envío * </label>

                                <input type="date" name="fecha_envio" class="form-control" value="{{ $ordenCompraData->fecha_envio ?: old('fecha_envio') }}">
                                <?php if ($nro_licitacion){ ?>
                                    <span class="help-block text-danger"> 
                                        <strong>Error: Numero de licitacion vacio</strong>
                                    </span>
                                <?php } ?>

<!--                                             @if ($errors->has('fecha_envio'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('fecha_envio') }}</strong>
                                                </span>
                                                @endif -->
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="container">
                                        <div class="row col-12">
                                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('total') ? 'has-error' : '' }}">
                                                <label>Total</label>
                                                
                                                <input type="text" name="total" class="form-control" value="<?=isset($_GET["total"]) ? $_GET["total"]: '' ?>">

                                                <?php if ($total){ ?>
                                                <span class="help-block text-danger"> 
                                                    <strong>Error: Total vacio</strong>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>   
 

                                    <div class="container">
                                        <div class="row col-12">
                                            <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4 {{ $errors->has('estado') ? 'has-error' : ''}}">
                                                <label>Estado *</label>
                                                <select class="selectpicker selectField" placeholder='Seleccione Estado' name="estado" id="estado">
                                                    <option value="Aceptado">Aceptado</option>
                                                    <option value="Pendiente">Pendiente</option>
                                                    <option value="Recepción Conforme">Recepción Conforme</option>

                                                </select>
                                                <?php if ($estado){ ?>
                                                    <span class="help-block text-danger"> 
                                                        <strong>Error: Numero de estado vacio</strong>
                                                    </span>
                                                <?php } ?>

<!--                                                 @if ($errors->has('estado'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('estado')}}</strong>
                                                </span>                        
                                                @endif -->
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
                
                <script src="<?= base(); ?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
                <script src="<?= base(); ?>/assets/assets/frontend/js/selectize.js"></script>
                <script>
                    $('.selectField').selectize({
                        create: false,            
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