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

		$nro_licitacion = false;
		$presupuesto = false;
		$archivo_licitacion = false;
		$descripcion_licitacion = false;


		if(sizeof($_GET)){
			if(!isset($_GET["nro_licitacion"])){
				$nro_licitacion = !$nro_licitacion;
			}
			if(!isset($_GET["presupuesto"])){
				$presupuesto = !$presupuesto;
			}
			if(!isset($_GET["archivo_licitacion"])){
				$archivo_licitacion = !$archivo_licitacion;
			}
			if(!isset($_GET["descripcion_licitacion"])){
				$descripcion_licitacion = !$descripcion_licitacion;
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
                <form method="post" class="form-horizontal" action="<?=base("/ordenCompra/new");?>" enctype="multipart/form-data">
                    <!-- {!! csrf_field() !!} -->
                    <div class="container">
                        <div class="row col-12">
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('numeroLicitacion') ? 'has-error' : ''}}">
                                <label> ID Contrato *</label><br>
                                <select class="selectpicker selectField" aceholder='Ingrese Número de Contrato' name="numeroLicitacion" id="numeroLicitacion" >                                        
                                    <?php 
                                    foreach ($dataProveedores as $proveedor) { 
                                        if (!empty($_GET["numeroLicitacion"]) && $_GET["numeroLicitacion"] == $proveedor["RUT"]){
                                            ?>
                                            <option selected="true" value="<?= $proveedor["RUT"];?>"><?= $proveedor["RUT"];?></option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="<?= $proveedor["RUT"];?>"><?= $proveedor["RUT"];?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                        <!-- 
                                            @foreach($contratos as $entityId => $entityValue)
                                                <option selected="true" value="{{ $entityId }}" >{{ $entityValue == 0 ? 'LC-'.$entityId : 'TD-' .$entityId }}</option>
                                                @endforeach                                  -->
                                            </select>                                       

                                        </div>
                                    </div>
                                </div>                        

                                <div class="container">
                                    <div class="row col 12">
                                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg4 {{ $errors->has('numeroOrdenCompra') ? 'has-error' : ''}}">
                                            <label>Número Orden de Compra * </label>

                                            <input type="text" name="numeroOrdenCompra"  class="form-control" value="{{ $ordenCompraData->numeroOrdenCompra ?: old('numeroOrdenCompra') }}">
<!--                                     @if ($errors->has('numeroOrdenCompra'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('numeroOrdenCompra')}}</strong>
                                        </span>
                                    @endif
                                -->
                                <?php if ($nro_licitacion){ ?>
                                    <span class="help-block text-danger"> 
                                        <strong>Error: Numero de licitacion vacio</strong>
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
                                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('total') ? 'has-error' : ''}}">
                                                <label>Total *</label>

                                                <input type="number" name="total" class="form-control" value="{{ $ordenCompraData->total}}">
                                                <?php if ($nro_licitacion){ ?>
                                                    <span class="help-block text-danger"> 
                                                        <strong>Error: Numero de licitacion vacio</strong>
                                                    </span>
                                                <?php } ?>

                                            <!-- @if (session('total'))
                                                <div class="help-block text-danger">
                                                    {{ session('total') }}
                                                </div>
                                            @endif
                                            
                                            @if ($errors->has('total'))
                                                <span class="help-block text-danger">
                                                    <strong>{{ $errors->first('total') }}</strong>
                                                </span>                        
                                                @endif -->
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
                                                <?php if ($nro_licitacion){ ?>
                                                    <span class="help-block text-danger"> 
                                                        <strong>Error: Numero de licitacion vacio</strong>
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
                                                <input type="file" class="form-control-file" name="archivo_orden_c">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <button type="submit" class="btn-primary btn rounded" ><i class="icon-floppy-disk"></i> Guardar</button>
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