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

		ob_start();

		?>


    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
			<a href="<?= base("/ordenCompra");?>">Orden de Compra</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-header">
			<form method="get" class="form-horizontal" action="<?= base("/ordenCompra");?>">

                <div class="row">
                    <div class="col-3">
						<label>ID Contrato</label>
                        <div>
						<select name="numeroLicitacion" class="selectpicker selectField" placeholder='Seleccione ID Contrato' data-live-search='true'>
                                <option value=""></option>
                                <?php
	                            foreach ($listado as $contrato){
	                            	if (!empty($_GET["numeroLicitacion"]) && $_GET["numeroLicitacion"] == $contrato["ID_CONTRATO"]){
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
                    <div class="col-3">
						<label>N° Orden de Compra</label>
                        <div>
							<select name="numeroOrden" class="selectpicker selectField" placeholder='Seleccione N° Orden de Compra' data-live-search='true'>
                                <option value=""></option>
                                <?php
	                            foreach ($listado as $orden) { 
									if (!empty($_GET["numeroOrden"]) && $_GET["numeroOrden"] == $orden["NRO_ORDEN_COMPRA"]){
										?>
										<option selected="true" value="<?= $orden["NRO_ORDEN_COMPRA"];?>"><?= $orden["NRO_ORDEN_COMPRA"];?></option>
										<?php
									}else{
										?>
										<option value="<?= $orden["NRO_ORDEN_COMPRA"];?>"><?= $orden["NRO_ORDEN_COMPRA"];?></option>
										<?php
									}
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
	                                foreach ($listado as $estado) { 
	                                    if (!empty($_GET["estado"]) && $_GET["estado"] == $estado["ESTADO"]){
	                                        ?>
	                                        <option selected="true" value="<?= $estado["ESTADO"];?>"><?= $estado["ESTADO"];?></option>
	                                        <?php
	                                    }else{
	                                        ?>
	                                        <option value="<?= $estado["ESTADO"];?>"><?= $estado["ESTADO"];?></option>
	                                        <?php
	                                    }
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
							<th>ID Contrato</th>
							<th>Nro. Licitación</th>
							<th>Nro. Orden de Compra</th>
							<th>Fecha de Envío</th>
							<th>Total</th>
							<th>Estado</th>
							<th>Adjunto</th> <!-- Implementar pdf-->
							<th>Acción</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    	<?php
                    	foreach ($listado as $ordenCompra) {
							?>
                        <tr>
							<td><?= $ordenCompra["ID_CONTRATO"];?></td>
							<td><?= $ordenCompra["NRO_LICITACION"];?></td>
							<td><?= $ordenCompra["NRO_ORDEN_COMPRA"];?></td>
							<td><?= $ordenCompra["FECHA_ENVIO"];?></td>
							<td><?= $ordenCompra["TOTAL"];?></td>
							<td><?= $ordenCompra["ESTADO"];?></td> 
							<td>
								<a href="<?= base()."/archivo/download?id=".$ordenCompra['NRO_DOCUMENTO'] ?>" target="_blank">
									<?= $ordenCompra["NOMBRE_DOCUMENTO"] ?>
								</a>
						
							</td>
                                <td>
                                    <?php if(!$proveedores["FECHA_ELIMINACION"]){ ?>
                                        <a href="#" data-target="#miModal<?=$index;?>" data-toggle="modal" class="btn btn-danger btn-xs"  ><i class="far fa-trash-alt"></i> Eliminar</a>
                                        <!-- modal starts -->
                                        <div class="modal fade" id="miModal<?= $index; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/ordenCompra/delete?id=").$ordenCompra["NRO_ORDEN_COMPRA"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar <?= $ordenCompra["NRO_ORDEN_COMPRA"]; ?> </h4>
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
                                        <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal<?=$proveedores["RUT_PROVEEDOR"];?>" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a>

                                        <!-- modal starts -->
                                        <div class="modal fade" id="restoreModal<?=$proveedores["RUT_PROVEEDOR"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/ordenCompra/new?restore=true&id=").$ordenCompra["NRO_ORDEN_COMPRA"];?>" >

                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Restaurar  <?=$proveedores["RAZON_SOCIAL"];?> </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                        
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Restaurar</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- modal ends -->

                                        <!-- modal starts -->
                                        <div class="modal fade" id="forceDeleteModal<?=$proveedores["RUT"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/proveedores/delete?force=true&id=").$proveedores["ID"];?>" >
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> Borrar permanentemente <?=$proveedores["RAZON_SOCIAL"];?> </h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                        
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Eliminar</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- modal ends -->

                                        


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
        
        <div class="card-footer">
        	<?=paginador($totales, base("/ordenCompra"), 12);?>
        </div>
    </div>

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

        $('.selectMulti').selectize({
            maxItems: 3
        });
	</script>






		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}