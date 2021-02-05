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


        $dataContratos = $model->getContratos();

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

		ob_start();

		?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=base("/ordenCompra");?>">Orden de Compra</a>
            </li>
            <!-- <li class="breadcrumb-item active">Mantenedor</li> -->
        </ol>

        <form method="post" class="form-horizontal" action="<?=base();?>/ordenCompra/new" enctype="multipart/form-data">

            <div class="card mb-3">
                <div class="card-body">

                    <?php feedback();?>

                    <div class="row">

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
                            <input type="hidden" name="id" value="<?=isset($_GET["nro_orden_compra"]) ? $_GET["nro_orden_compra"]: "" ?>" >
                        </div>



                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$nro_orden_compra ? 'has-error' : '' ;?>" id="nro_orden_compra">
                            <label>Número Orden de Compra * </label>

                            <!-- <input type="text" name="numeroOrdenCompra"  class="form-control" value="{{ $ordenCompraData->numeroOrdenCompra ?: old('numeroOrdenCompra') }}"> -->
                            <input type="text" name="nro_orden_compra"  class="form-control" required
                                   value="<?= $_GET["nro_orden_compra"] ?? $registroEdit['NRO_ORDEN_COMPRA'] ?>">

                        </div>



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


<!--                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('total') ? 'has-error' : '' }}">-->
<!--                            <label>Total</label>-->
<!---->
<!--                            <input type="text" name="total" class="form-control" required-->
<!--                                   value="--><?//= $_GET["total"] ?? $registroEdit['TOTAL'] ?><!--">-->
<!---->
<!---->
<!--                        </div>-->

                        <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4 {{ $errors->has('estado') ? 'has-error' : ''}}">
                            <label>Estado *</label>
                            <select class="selectpicker selectField" placeholder='Seleccione Estado' name="estado" id="estado" value="<?=isset($_GET["estado"]) ? $_GET["estado"]: (isset($registroEdit["ESTADO"]) ? $registroEdit["ESTADO"] : "") ?>">
                                <option value="Aceptado" <?=$registroEdit['ESTADO']=='Aceptado' ? 'selected' : ''?>>Aceptado</option>
                                <option value="Pendiente" <?=$registroEdit['ESTADO']=='Pendiente' ? 'selected' : ''?>>Pendiente</option>
                                <option value="Recepcion Conforme" <?=$registroEdit['ESTADO']=='Recepcion Conforme' ? 'selected' : ''?>>Recepcion Conforme</option>

                            </select>


                        </div>


                        <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
                            <label for="">Adjuntar Orden de Compra</label>
                            <div class="custom-file">
                                <input type="file" name="archivo_orden_compra" class="custom-file-input" id="customFileLangHTML" lang="es" >
                                <label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-outline card-success">
                                <div class="card-header pb-1">
                                    <h5 class="card-title">Detalles</h5>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                        <tr>
                                            <th>Detalle</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Agrear</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if ($registroEdit && count($registroEdit['detalles'])){
                                                ?>
                                                <tr>
                                                    <th>Detalle</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>
                                                        <a name="" id=""
                                                           class="btn btn-danger"
                                                           href="#" role="button">Eliminar</a>
                                                    </th>
                                                </tr>
                                                <?php
                                            } else{
                                                ?>
                                                <tr>
                                                    <th>Detalle</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>
                                                        <a name="" id=""
                                                           class="btn btn-danger"
                                                           href="#" role="button">Eliminar</a>
                                                    </th>
                                                </tr>
                                                <?php
                                            }
                                        ?>

                                        <tr>
                                            <td width="45%">
                                                <select name='detalle_contrato' class='selectpicker'
                                                        placeholder='Seleccione un contrato'
                                                        data-live-search='true' id='detalle_contrato'>

                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="cantidad" id="cantidad" readonly value="0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="cantidad" id="cantidad" readonly value="0">
                                            </td>
                                            <td>
                                                <a name="" id="" class="btn btn-success"
                                                   href="#" role="button">Agregar</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>


                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn-primary btn rounded" name="submit" value="1" >
                                <i class="icon-floppy-disk"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>



        <script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
        <script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
        <script>

            var optionsSelect = {
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                dropdownParent: 'body'

            };

			$('.selectField').selectize(optionsSelect);

            var $selectDetalleContrato = $(document.getElementById('detalle_contrato')).selectize(optionsSelect);


			$('#selectContrato').selectize({

				create: false,
				sortField: {
					field: 'text',
					direction: 'asc'
				},
				dropdownParent: 'body',
				onChange: function(value) {

				    console.log('cambio select contrato');
				    var data = {
				        id: value
                    };

                    $.ajax({
                        method: 'POST',
                        url: '<?=base()."/get/detalles/contratos/ajax";?>',
                        data: data,
                        dataType: 'json',
                        success: function (res) {
                            console.log('respuesta ajax:',res)



                            var selectize = $selectDetalleContrato[0].selectize;

                            selectize.clearOptions();


                            if (Array.isArray(res)){
                                $.each(res, function(index,item) {
                                    console.log('add item:',item);
                                    selectize.addOption(item);
                                    selectize.addItem(1);
                                });
                                selectize.refreshOptions();
                                selectize.settings.placeholder = "Seleccione un item...";
                            }else{
                                selectize.settings.placeholder = res;
                            }

                            selectize.updatePlaceholder()




                        },
                        error: function (res) {
                            console.log('respuesta ajax:',res);

                        }
                    })
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