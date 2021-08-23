<?php



namespace OrdenCompraShow;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewOrdenCompraShow {

	public function output(ModelOrdenCompraShow $model){



        $orden = $model->get();


		ob_start();

		?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=base("/ordenCompra");?>" class="encabezado">Orden de Compra</a>
            </li>
            <!-- <li class="breadcrumb-item active">Mantenedor</li> -->
        </ol>



        <div class="card mb-3">
            <div class="card-body">

                <?php feedback2();?>


                <div class="row ">

                    <div class="form-group col-sm-12">

                        <label for="">TIPO: </label>
                        <b><?=$orden['TIPO']?></b><br>

                        <label for="">NRO ORDEN: </label>
                        <b><?=$orden['NRO_ORDEN_COMPRA']?></b><br>

                        <label for="">ID CONTRATO: </label>
                        <b><?=$orden['ID_CONTRATO']?></b><br>

                        <label for="">FECHA ENVIO: </label>
                        <b><?=$orden['FECHA_ENVIO']?></b><br>

                        <label for="">TOTAL: </label>
                        <b><?=nfp($orden['TOTAL'])?></b><br>

                        <label for="">ESTADO: </label>
                        <b><?=$orden['ESTADO']?></b><br>

                        <label for="">FECHA CREACION: </label>
                        <b><?=$orden['FECHA_CREACION']?></b><br>

                        <label for="">FECHA ACTUALIZACION: </label>
                        <b><?=$orden['FECHA_ACTUALIZACION']?></b><br>

                        <label for="">DESCRIPCION: </label>
                        <b><?=$orden['DESCRIPCION']?></b><br>

                        <label for="">USUARIO CREA: </label>
                        <b><?=$orden['USUARIO_CREA']?></b><br>

                        <label for="">USUARIO ACTUALIZA: </label>
                        <b><?=$orden['USAURIO_ACTUALIZA']?></b><br>

                        <?php
                            if($orden["ESTADO"]!='Anulada') {
                                ?>

                                <a href="<?= base("/ordenCompra/new?nro_orden_compra=") . $orden["NRO_ORDEN_COMPRA"]; ?>"
                                   class="btn btn-sm btn-primary btn-xs">
                                    <i class="fa fa-pencil-alt"></i> Editar
                                </a>

                                <a href="#" data-target="#miModal" data-toggle="modal"
                                   class="btn btn-sm btn-danger btn-xs"><i class="far fa-trash-alt"></i> Anular
                                </a>

                                <div class="modal fade" id="miModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" method="post" action="<?=base("/ordenCompra?anula=1&nro_orden_compra=").$orden["NRO_ORDEN_COMPRA"];?>" >
                                                <div class="modal-header">
                                                    <h4 class="modal-title"> Anular Orden de Compra n°<?= $orden["NRO_ORDEN_COMPRA"]; ?> </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger">Continuar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        ?>


                    </div>
                </div>



                    <div class="card card-outline card-success">
                        <div class="card-header p-1">
                            <h5 class="card-title m-1">Detalles</h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php
                            if (count($orden['DETALLES'])>0){
                                ?>
                                <table class="table table-bordered table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>DESCRIPCION</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO</th>
                                    <th>SUB TOTAL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($orden['DETALLES'] as $det) {
                                    ?>
                                    <tr>
                                        <td><?=$det['CODIGO']?></td>
                                        <td><?=$det['DESCRIPCION']?></td>
                                        <td><?=nfp($det['CANTIDAD'])?></td>
                                        <td><?=nfp($det['PRECIO'])?></td>
                                        <td><?=nfp($det['SUBTOTAL'])?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th><?=nfp($orden['TOTAL'])?></th>
                                </tr>
                                </tfoot>
                            </table>

                                <?php
                            }else{
                                ?>
                                <h5 class="text-center text-info">Sin detalles</h5>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- /.card-body -->
                    </div>


            </div>

        </div>




        <script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
        <script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>




        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
//		return "";

    }
}