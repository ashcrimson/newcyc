<?php

      
 
namespace OrdenCompraList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewOrdenCompra {
	
	public function output(\OrdenCompraList\ModelOrdenCompra $model){

		$data = $model->get();

		$listado = $data[0];
        $totales = $data[1];
        
        $dataListBox = $model->getDataListBox();

        //arrays para los selects
        $contratos = $dataListBox['contratos'];
        $ordenes_compra = $dataListBox['ordenes_compra'];

		ob_start();

		?>


    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
			<a href="<?= base("/ordenCompra");?>" class="encabezado">Ordenes de Compra</a>
        </li>
       
    </ol>

        <?php feedback2();?>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-header">
			<form method="get" class="form-horizontal" action="<?= base("/ordenCompra");?>">

                <div class="row">
                    <!-- <div class="col-3">
                        <label>ID Contrato</label>
                            <div>
                                <select name="id_contrato" class="selectpicker selectField" placeholder='Seleccione Contrato' data-live-search='true'>
                                    <option value=""></option>
                                    <?php 
                                    foreach ($contratos as $index => $contrato) {
                                        
                                        $selected = $_GET["id_contrato"]==$contrato["ID_CONTRATO"] ? 'selected' : '';
                                        ?>
                                        
                                            <option value="<?=$contrato["ID_CONTRATO"]; ?>" <?=$selected?>>
                                            <?= $contrato["TIPO"] ."-". $contrato["ID_CONTRATO"]; ?>
                                            </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                    </div> -->

                    
                    <div class="col-3">
                        <label>ID Mercado Público</label>
                            <div>
                                <select name="id_mercado_publico" class="selectpicker selectField" placeholder='Seleccione Contrato' data-live-search='true'>
                                    <option value=""></option>
                                    <?php 
                                    foreach ($contratos as $index => $contrato) {
                                        
                                        $selected = $_GET["id_mercado_publico"]==$contrato["ID_MERCADO_PUBLICO"] ? 'selected' : '';
                                        ?>
                                        
                                            <option value="<?=$contrato["ID_MERCADO_PUBLICO"]; ?>" <?=$selected?>>
                                            <?= $contrato["ID_MERCADO_PUBLICO"]; ?>
                                            </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>

                    

                    <div class="col-3">
                        <label>N° Orden de Compra</label>
                            <div>
                                <select name="ordenes_compra" class="selectpicker selectField" placeholder='Seleccione Orden de Compra' data-live-search='true'>
                                    <option value=""></option>
                                    <?php 
                                    foreach ($ordenes_compra as $index => $orden) {
                                        
                                        $selected = $_GET["ordenes_compra"]==$orden["NRO_ORDEN_COMPRA"] ? 'selected' : '';
                                        ?>
                                        
                                            <option value="<?=$orden["NRO_ORDEN_COMPRA"]; ?>" <?=$selected?>>
                                            <?=$orden["NRO_ORDEN_COMPRA"]; ?>
                                            </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="col-3">
                        <label>Estado</label>
                        <div>
                            <select name="estado" class="selectpicker selectField" placeholder='Seleccione Estado' data-live-search='true'>                                <option value=""></option>
                            <option value=""></option>
                                    <?php 
                                    foreach (['Aceptado', 'Pendiente', 'Recepcion Conforme','Anulada'] as $index => $estado) {
                                        
                                        $selected = $_GET["estado"]==$estado ? 'selected' : '';
                                        ?>
                                        
                                            <option value="<?=$estado; ?>" <?=$selected?>>
                                            <?=$estado; ?>
                                            </option>
                                        <?php
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="btn-group float-right ml-3">
					<a href="<?=base("/ordenCompra/new/");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>         
                </div>

                <div class="btn-group float-right">
                    <?php if(!empty($_GET)){ ?> 
                        <a class="btn btn-default" href="<?=base("/ordenCompra");?>">Limpiar Filtros</a>
                    <?php } ?>
                        <button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
                    </div>

                <div>
                    <i class="fas fa-table"> Registros</i>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover nowrap" id="tablaCompras" width="100%" cellspacing="0">
                    <thead >
                        <tr >
							<th>ID Mercado Público</th>
							<th>Nro. Orden de Compra</th>
							<th>Fecha de Envío</th>
							<th>Total</th>
							<th>Estado</th>
							<th>Adjunto</th> <!-- Implementar pdf-->
                            <th>Creada por</th>
                            <th>Actualizada por</th>
							<th>Acción</th>
                        </tr>
                    </thead>
                    
                    <tbody  >
                    	<?php
                    	foreach ($listado as $index => $ordenCompra) {
						?>
                        <tr >
							<td><?= $ordenCompra["ID_MERCADO_PUBLICO"];?></td>
							<td><?= $ordenCompra["NRO_ORDEN_COMPRA"];?></td>
							<td><?= $ordenCompra["FECHA_ENVIO"];?></td>
                            <td>$<?= number_format($ordenCompra["TOTAL"], 2, ',', '.') ?></td>

                            <td><?= $ordenCompra["ESTADO"];?></td>
							<td>
								<a href="<?= base()."/archivo/download?id=".$ordenCompra['NRO_DOCUMENTO'] ?>" target="_blank">
									<?= $ordenCompra["NOMBRE_DOCUMENTO"] ?>
								</a>
						
							</td>
                            <td> <?= $ordenCompra["USUARIO_CREA"]; ?></td>
                            <td> <?= $ordenCompra["USAURIO_ACTUALIZA"]; ?></td>
                                <td>

                                    <a href="<?=base("/ordenCompra/show?id=").$ordenCompra["NRO_ORDEN_COMPRA"];?>"
                                       class="btn btn-sm btn-secondary "
                                       data-toggle="tooltip" title="Ver">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <?php if($ordenCompra["ESTADO"]!='Anulada'){ ?>

                                        <a href="<?=base("/ordenCompra/new?nro_orden_compra=").$ordenCompra["NRO_ORDEN_COMPRA"];?>"
                                           class="btn btn-sm btn-primary "
                                           data-toggle="tooltip" title="Editar">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>

                                        <span data-toggle="tooltip" title="Anular">
                                            <a href="#" data-target="#miModal<?=$index;?>" data-toggle="modal" class="btn btn-sm btn-danger "  >
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </span>
                                        <!-- <a href="#" data-target="#restoreModal<?=$index;?>" data-toggle="modal" class="btn btn-sm btn-info btn-xs"  ><i class="far fa-eye"></i> Restaurar</a> -->
                                        <!-- modal starts -->
                                        <div class="modal fade" id="miModal<?= $index; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/ordenCompra?anula=1&nro_orden_compra=").$ordenCompra["NRO_ORDEN_COMPRA"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Anular Orden de Compra n°<?= $ordenCompra["NRO_ORDEN_COMPRA"]; ?> </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default">Continuar</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- modal ends -->
                                       
                                    <?php
                                }else{
                                	?>



                                    <?php
                                }
                                ?>
                                </td>
        
                            </tr>
                        <?php 
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        
<!--        <div class="card-footer">-->
<!--        	--><?//=paginador($totales, base("/ordenCompra"), 12);?>
<!--        </div>-->
    </div>

    <script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
    <script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
    <script src="<?=base();?>/assets/assets/vendor/datatables/datatables.min.js"></script>

        <script>
        $('.selectField').selectize({
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });

        $('.selectMulti').selectize({
            maxItems: 3
        });
	</script>

        <script>


                var dt = $('#tablaCompras').DataTable({
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal( {
                                header: function ( row ) {
                                    var data = row.data();
                                    return 'Detalles de orden compra: '+data[0];
                                }
                            } ),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                                tableClass: 'table'
                            } )
                        }
                    },
                    columnDefs: [
                        { responsivePriority: 2, targets: -1 }
                    ],
                    // dom: 'Br',
                    dom: 'Bltrip',
                    buttons: [
                         'excel'
                    ],
                    pageLength: 0,
                    lengthMenu: [10, 20, 50, 100, 200, 500]
                });



                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })

        </script>



    <?php

    $output = ob_get_contents();
    ob_end_clean();

    return $output;
//		return "";

	}
}