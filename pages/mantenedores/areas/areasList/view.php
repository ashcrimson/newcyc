<?php

 

namespace AreasList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class viewAreas {
	
	public function output(\AreasList\ModelAreas $model){

		$data = $model->get();

		$listaAreas = $data[0];
		$numerosAreas = $data[1];
		$totales = $data[2];
		ob_start();

		?>



<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?=base("/areas/");?>" class="encabezado">Areas</a>
    </li>
  
</ol>

<?php feedback2();?>

<div class="card mb-3">
    <div class="card-header">
        <form method="get" class="form-horizontal" action="<?=base("/areas/");?>">
            

            <div class="row">
                <div class="col-3">
                    <label>Filtro por nombre</label>
                    <div>
                        <select name="tipo" class="selectpicker selectField" placeholder='Seleccione area' data-live-search='true'>
                            <option value=""></option>
                            <?php
                            foreach ($listaAreas as $areas){
                            	$select =  ($_GET["tipo"] == $areas["ID_AREA"]) ? "selected" : '';
	                            ?>
	                            <option value="<?=$areas["ID_AREA"];?>" <?=$select;?>>
                                    <?=$areas["AREA"];?>
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
                <a href="<?=base("/areas/new/");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>         
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
 -->        <div class="table table-sm table-bordered table-hover nowrap">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	foreach ($listaAreas as $areas) {
                		?>
                    <tr>
                        <td><?=$areas["AREA"];?></td>
                        <td><?=$areas["NOMBRE_CARGO"];?></td>
                        <td>
                        	<?php
                        	if(!$areas["ELIMINADO"]){
                        		?>
                            <a href="<?=base("/areas/new?id=").$areas["ID_AREA"];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                            <a href="#" class="btn btn-danger btn-xs" data-target="#deleteModal<?=$areas["ID_AREA"];?>" data-toggle="modal"><i class="far fa-trash-alt"></i> Eliminar</a>

                            <!-- modal starts -->
                            <div class="modal fade" id="deleteModal<?=$areas["ID_AREA"];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" action="<?=base("/areas/delete?id=").$areas["ID_AREA"];?>" >
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Borrar <?=$areas["AREA"];?> </h4>
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
                            <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal<?=$areas["ID_AREA"];?>" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a>
                            

                            <!-- modal starts -->
                            <div class="modal fade" id="restoreModal<?=$areas["ID_AREA"];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" action="<?=base("/areas/new?restore=true&id=").$areas["ID_AREA"];?>" >

                                            <div class="modal-header">
                                                <h4 class="modal-title"> Restaurar  <?=$areas["AREA"];?> </h4>
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
                            <div class="modal fade" id="forceDeleteModal<?=$areas["ID_AREA"];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" action="<?=base("/areas/delete?force=true&id=").$areas["ID_AREA"];?>" >
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Borrar permanentemente <?=$areas["AREA"];?> </h4>
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
    	paginador($totales, "/newcyc/areas");
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