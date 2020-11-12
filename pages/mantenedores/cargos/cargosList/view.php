<?php

 

namespace CargosList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class viewCargos {
	
	public function output(\CargosList\ModelCargos $model){

		$data = $model->get();

		$listaCargos = $data[0];
		$numerosCargos = $data[1];
		$totales = $data[2];
		ob_start();

		?>



<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base("/cargos/");?>">Cargos</a>
    </li>
    <li class="breadcrumb-item active">Mantenedor</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <form method="get" class="form-horizontal" action="<?=base("/cargos/");?>">
            

            <div class="row">
                <div class="col-3">
                    <label>Filtro por nombre</label>
                    <div>
                        <select name="tipo" class="selectpicker selectField" placeholder='Seleccione cargo' data-live-search='true'>
                            <option value=""></option>
                            <?php
                            foreach ($listaCargos as $cargos){
                            	if ($_GET["tipo"] == $cargos["ID_CARGO"]) {
	                            	?>
	                            	<option value="<?=$cargos["ID_CARGO"];?>" selected="true"><?=$cargos["NOMBRE"];?></option>
	                            	<?php
                            	}else{
	                            	?>
	                            	<option value="<?=$cargos["ID_CARGO"];?>"><?=$cargos["NOMBRE"];?></option>
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
                <a href="<?=base("/cargos/new/");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>         
            </div>

            <div class="btn-group float-right">
            	<?php
            	if(!empty($_GET["tipo"])){
            		?>
                	<a class="btn btn-default" href="{{ route('cargos.index') }}">Limpiar Filtros</a>
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
<!--         @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
 -->        <div class="table-responsive table-sm -md -lg -x">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	foreach ($listaCargos as $cargos) {
                		?>
                    <tr>
                        <td><?=$cargos["NOMBRE"];?></td>
                        <td>
                        	<?php
                        	if(!$cargos["ELIMINADO"]){
                        		?>
                            <a href="<?=base("/cargos/new?id=").$cargos["ID_CARGO"];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                            <a href="#" class="btn btn-danger btn-xs" data-target="#deleteModal<?=$cargos["ID_CARGO"];?>" data-toggle="modal"><i class="far fa-trash-alt"></i> Eliminar</a>

                            <!-- modal starts -->
                            <div class="modal fade" id="deleteModal<?=$cargos["ID_CARGO"];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" action="<?=base("/cargos/delete?id=").$cargos["ID_CARGO"];?>" >
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Borrar <?=$cargos["NOMBRE"];?> </h4>
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
                            <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal<?=$cargos["ID_CARGO"];?>" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a>
                            

                            <!-- modal starts -->
                            <div class="modal fade" id="restoreModal<?=$cargos["ID_CARGO"];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" action="<?=base("/cargos/new?restore=true&id=").$cargos["ID_CARGO"];?>" >

                                            <div class="modal-header">
                                                <h4 class="modal-title"> Restaurar  <?=$cargos["NOMBRE"];?> </h4>
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
                            <div class="modal fade" id="forceDeleteModal<?=$cargos["ID_CARGO"];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" action="<?=base("/cargos/delete?force=true&id=").$cargos["ID_CARGO"];?>" >
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Borrar permanentemente <?=$cargos["NOMBRE"];?> </h4>
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
                            <!-- @endif -->
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
    	paginador($totales, "/newcyc/cargos");
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