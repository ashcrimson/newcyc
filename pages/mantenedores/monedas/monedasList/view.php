<?php



namespace MonedasList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewMonedas {
	
	public function output(\MonedasList\ModelMonedas $model){

		$data = $model->get();

		$listaMonedas = $data[0];
		$numerosMonedas = $data[1];
		$totales = $data[2];


		ob_start();

		?>




    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/monedas");?>">Monedas</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-header">
            <form method="get" class="form-horizontal" action="<?=base("/monedas");?>">

                <div class="row">
                    <div class="col-3">
                        <label>Filtro por código</label>
                        <div>
                            <select name="tipo" class="selectpicker selectField" placeholder='Seleccione moneda' data-live-search='true'>
                                <option value=""></option>
<!--                                 @foreach($tiposData as $entityId => $entityValue)
                                    <option value="{{ $entityId }}" >{{ $entityValue }}</option>
                                @endforeach
 -->							<?php
	                            foreach ($listaMonedas as $moneda){
	                            	if ($_GET["tipo"] == $moneda["CODIGO"]) {
		                            	?>
		                            	<option value="<?=$moneda["CODIGO"];?>" selected="true"><?=$moneda["NOMBRE"];?></option>
		                            	<?php
	                            	}else{
		                            	?>
		                            	<option value="<?=$moneda["CODIGO"];?>"><?=$moneda["NOMBRE"];?></option>
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
                    <a href="<?=base("/monedas/new");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>
                </div>

                <div class="btn-group float-right">
	            	<?php
	            	if(!empty($_GET["tipo"])){
	            		?>
                        <a class="btn btn-default" href="<?=base("/monedas");?>">Limpiar Filtros</a>
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
            <!-- @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif -->
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Pesos Chilenos</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                    	<?php
                    	foreach ($listaMonedas as $monedas) {
                			?>
                        
                            <tr>
                                <td> <?= $monedas["CODIGO"]; ?></td>
                                <td> <?= $monedas["NOMBRE"]; ?></td>
                                <td> <?= $monedas["EQUIVALENCIA"]; ?></td>
                                <td>
                                <?php if(!$monedas["ELIMINADO"]) { ?>
                                        <a href="<?=base("/monedas/new?id=").$monedas["CODIGO"];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-target="#deleteModal<?= $monedas["CODIGO"]; ?>" data-toggle="modal"><i class="far fa-trash-alt"></i> Eliminar</a>

                                        <!-- modal starts -->
                                        <div class="modal fade" id="deleteModal<?= $monedas["CODIGO"]; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/monedas/delete?id=").$monedas["CODIGO"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar <?= $monedas["NOMBRE"]; ?> </h4>
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
                                        <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal<?= $monedas["CODIGO"]; ?>" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a>
        

                                        <!-- modal starts -->
                                        <div class="modal fade" id="restoreModal<?= $monedas["CODIGO"]; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/monedas/new?restore=true&id=").$Monedas["CODIGO"];?>" >

                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Restaurar  <?= $monedas["NOMBRE"]; ?> </h4>
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
                                        <div class="modal fade" id="forceDeleteModal<?= $monedas["CODIGO"]; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/monedas/delete?force=true&id=").$monedas["CODIGO"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar Permanentemente <?= $monedas["NOMBRE"]; ?> </h4>
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
	    	<?php
	    	paginador($totales, "/monedas");
	    	?>
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