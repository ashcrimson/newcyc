<?php



namespace ProveedoresList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewProveedores {
	
	public function output(\ProveedoresList\ModelProveedores $model){

		$data = $model->get();

		$listaProveedores = $data[0];
		$numerosLicitaciones = $data[1];
		$totales = $data[2];

		ob_start();

		?>


    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/proveedores/");?>">Proveedores</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-header">
            <form method="get" class="form-horizontal" action="<?=base("/proveedores/");?>">

                <div class="row">
                    <div class="col-3">
                        <label>Filtrar por RUT</label>
                        <div>
                            <select name="rut" class="selectpicker selectField" placeholder='Seleccione RUT' data-live-search='true'>
                                <option value=""></option>
                                <?php
	                            foreach ($listaProveedores as $proveedores){
	                            	if ($_GET["rut"] == $proveedores["rut"]) {
		                            	?>
		                            	<option value="<?=$proveedores["RUT_PROVEEDOR"];?>"><?=$proveedores["RUT_PROVEEDOR"];?></option>
		                            	<?php
	                            	}else{
		                            	?>
		                            	<option value="<?=$proveedores["RUT_PROVEEDOR"];?>"><?=$proveedores["RUT_PROVEEDOR"];?></option>
		                            	<?php
	                            	}
	                            }
	                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label>Filtrar por razón social</label>
                        <div>
                            <select name="razon_social" class="selectpicker selectField" placeholder='Seleccione razón social' data-live-search='true'>
                                <option value=""></option>
                                <?php
	                            foreach ($listaProveedores as $proveedores){
	                            	if ($_GET["razon_social"] == $proveedores["RUT_PROVEEDOR"]) {
		                            	?>
		                            	<option value="<?=$proveedores["RUT_PROVEEDOR"];?>"><?=$proveedores["RAZON_SOCIAL"];?></option>
		                            	<?php
	                            	}else{
		                            	?>
		                            	<option value="<?=$proveedores["RUT_PROVEEDOR"];?>"><?=$proveedores["RAZON_SOCIAL"];?></option>
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
                    <a href="<?=base("/proveedores/new");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>
                </div>

                <div class="btn-group float-right">
	            	<?php
	            	if(!empty($_GET["rut"]) || !empty($_GET["razon_social"])){
	            		?>
                        <a class="btn btn-default" href="<?=base("/proveedores/");?>">Limpiar Filtros</a>
	            		<?php
	            	}
            		?>
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
                            <th>Rut</th>
                            <th>Razón social</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    	<?php
                    	foreach ($listaProveedores as $proveedores) {
                    	?>
                            <tr>
                                <td> <?= $proveedores["RUT_PROVEEDOR"]; ?></td>
                                <td> <?= $proveedores["RAZON_SOCIAL"] ?></td>
                                <td>
                                    <?php if(!$proveedores["FECHA_ELIMINACION"]){ ?>
                                        <a href="<?=base("/proveedores/new?id=").$proveedores["RUT_PROVEEDOR"];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-target="#deleteModal<?=$proveedores["RUT_PROVEEDOR"];?>" data-toggle="modal"><i class="far fa-trash-alt"></i> Eliminar</a>

                                        <!-- modal starts -->
                                        <div class="modal fade" id="deleteModal<?=$proveedores["RUT_PROVEEDOR"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/proveedores/delete?id=").$proveedores["ID"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar <?=$proveedores["RAZON_SOCIAL"];?> </h4>
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
                                                    <form class="form-horizontal" method="post" action="<?=base("/proveedores/new?restore=true&id=").$proveedores["RUT_PROVEEDOR"];?>" >

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

                                        <!-- modal starts -->
                                        <div class="modal fade" id="miModal<?=$proveedores["RUT_PROVEEDOR"];?>">
                                            <p>hola mundo</p>
                                        </div>

                                        <!-- modal ends -->



                                    @endif
                                    <?php
                                }
                                ?>
                                <a href="#" data-id="<?=$proveedores['RUT_PROVEEDOR'];?>" class="btn btn-danger btn-xs" data-target="#miModal" data-toggle="modal"><i class="fa fa-phone" ></i> Contacto</a>
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
        	<?=paginador($totales, "/newcyc/proveedores");?>
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

    <script>
   
        $('#miModal').on('show.bs.modal', function(e) {
        console.log($(e.relatedTarget).data('id'));
        });
   
        
    </script>




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}