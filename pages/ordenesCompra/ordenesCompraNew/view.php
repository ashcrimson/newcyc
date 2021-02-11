<?php



namespace OrdenCompraNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewOrdenCompra {

	public function output(\OrdenCompraNew\ModelOrdenCompra $model){

		if(!empty($_POST)){
			$model->execute();

			if (!$model->hayErrores()){
                header("Location: ". base() . "/ordenCompra/new?nro_orden_compra=".$model->getId());
            }
        }

        if(isset($_GET["nro_orden_compra"])){
			$registroEdit = $model->get();

        }


        $dataContratos = $model->getContratos();



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
                            <label>
                                ID Contrato
                                <i class="fa fa-spinner fa-spin " style="display: none" id="iconLoading"></i>
                            </label>
                            <select class="selectpicker "
                                    placeholder='Seleccione Tipo de Contrato'
                                    name="id_contrato"
                                    id="selectContrato">
                                <option value=""></option>
                                <?php
                                foreach ($dataContratos as $contrato) {
                                    $selected = $registroEdit['ID_CONTRATO']==$contrato["ID_CONTRATO"] ? "selected" : "";
                                    ?>
                                    <option value="<?= $contrato["ID_CONTRATO"];?>" <?=$selected?> >
                                        <?=$contrato["TIPO"] ."-". $contrato["ID_CONTRATO"];?>
                                    </option>
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
                                    <?php
                                    if ($registroEdit){
                                        ?>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Sub Total</th>
                                                <th>Agrear</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if ($registroEdit && count($registroEdit['detalles_compra'])){
                                                $total = 0;
                                                foreach ($registroEdit['detalles_compra'] as $index => $detalle) {
                                                    $sub = $detalle['CANTIDAD'] * $detalle['PRECIO'];

                                                    $total += $sub;
                                                    ?>
                                                    <tr>
                                                        <td><?=$detalle['DESC_PROD_SOLI']." / ".$detalle['DESC_TEC_PROD_OFERTADO']?></td>
                                                        <td><?=$detalle['CANTIDAD']?></td>
                                                        <td><?=$detalle['PRECIO']?></td>
                                                        <td><?=$sub?></td>

                                                        <td>
                                                            <a href="<?=base()?>/ordenCompra/detalles/delete?nro_orden_compra=<?=$detalle['NRO_ORDEN_COMPRA']?>&id=<?=$detalle['ID']?>"
                                                               class="btn btn-danger"
                                                                role="button">Eliminar</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                            } else{
                                                ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-warning">No hay ningún detalles agregado</td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <tr id="filaNuevoDetalle">
                                                <td width="45%">
                                                    <select name='detalle_contrato' class='selectpicker'
                                                            placeholder='Seleccione un contrato'
                                                            data-live-search='true' id='detalle_contrato'>


                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="cantidad" id="cantidad" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="precio" id="precio" readonly value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="subtotal" readonly value="0">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="nro_orden_compra" value="<?=$registroEdit['NRO_ORDEN_COMPRA']?>">
                                                    <button type="button" id="btnAdd" class="btn btn-success"
                                                            href="#" role="button">Agregar</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3">Total</th>
                                                <th class="text-right" >
                                                    <span id="total">
                                                        <?=$total?>
                                                    </span>
                                                </th>
                                                <th></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <?php
                                    }else {
                                        ?>
                                        <h3 class="text-info text-center">
                                            Guarde primero para poder agregar detalles
                                        </h3>
                                        <?php
                                    }
                                    ?>

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


            <?php
            if ($registroEdit){
                ?>
                    getDetallesContrato("<?=$registroEdit['ID_CONTRATO']?>");
                <?php
            }
            ?>

            $('#selectContrato').selectize({
                create: false,
                dropdownParent: 'body',
                <?php
                if ($registroEdit){
                    ?>
                    onChange: function(value) {

                        $("#iconLoading").show();

                        getDetallesContrato(value)

                    }
                    <?php
                }
                ?>
            });



            var items = [];

            var $selectDetalleContrato = $('#detalle_contrato').selectize({
                create: false,
                dropdownParent: 'body',
                onChange: function(value) {
                    console.log('Selecciona el articulo:'+value,items);

                    var item = items.find( o => (o.value == value));

                    $("#filaNuevoDetalle").find("#precio").val(item.precio);
                    subTotal();

                }
            });

            function getDetallesContrato(id) {
                $.ajax({
                    method: 'POST',
                    url: '<?=base()."/get/detalles/contratos/ajax";?>',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (res) {
                        console.log('respuesta ajax:',res);

                        items = res;

                        var selectize = $selectDetalleContrato[0].selectize;

                        selectize.clearOptions();


                        if (Array.isArray(res)){
                            $.each(res, function(index,item) {
                                selectize.addOption(item);
                                selectize.addItem(1);
                            });
                            selectize.refreshOptions();
                            selectize.settings.placeholder = "Seleccione un item...";
                        }else{
                            selectize.settings.placeholder = res;
                        }

                        selectize.updatePlaceholder();

                        $("#iconLoading").hide();


                    },
                    error: function (res) {
                        console.log('respuesta ajax error:',res);
                        $("#iconLoading").hide();

                    }
                })
            }

            $("#cantidad").focus(function () {
                $(this).select();
            });

            $("#cantidad").keyup(function (e) {
                subTotal();
            });

            function subTotal(){

                var cantidad = parseFloat($("#cantidad").val());
                var precio = parseFloat($("#precio").val());


                if(cantidad && precio){
                    $("#subtotal").val(cantidad*precio) ;
                }
            }


			$("#btnAdd").click(function (e) {
                e.preventDefault();

                if(parseFloat($("#cantidad").val()) == 0){

                    alert('La cantidad debe ser mayor a 0');
                    $("#cantidad").focus().select();
                    return
                }


                var nuevoDet = $('#filaNuevoDetalle *').serialize();

                var uri = "<?=base()?>/ordenCompra/detalles/add?" + nuevoDet;

                console.log('Agregar item',uri);

                window.location.href= uri;
            })
        </script>



        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
//		return "";

    }
}