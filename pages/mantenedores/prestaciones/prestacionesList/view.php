<?php

    

namespace PrestacionesList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewPrestaciones {
	
	public function output(\PrestacionesList\ModelPrestaciones $model){

		$data = $model->get();

		$listaPrestaciones = $data[0];
		$totales = $data[1];

        $dataListBox = $model->getDataListBox();

        //arrays para los selects
        $prestaciones = $dataListBox['prestaciones'];

		ob_start();

		?>


    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/prestaciones/");?>" class="encabezado">Prestaciones</a>
        </li>
        
    </ol>

    <!-- DataTables -->
    <div class="card mb-3"> 
        <div class="card-header">
            <form method="get" class="form-horizontal" action="<?=base("/prestaciones/");?>">

                <div class="row">
                    <div class="col-3">
                        <label>Filtrar por Código</label>
                        <div>
                            <select name="codigo" class="selectpicker selectField" placeholder='Seleccione Código' data-live-search='true'>
                                <option value=""></option>
                                <?php
	                            foreach ($prestaciones as $prestacion){
                                    $selected = $prestacion["CODIGO"] == $_GET["codigo"] ? "selected" : "";
	                                ?>
                                    <option value="<?=$prestacion["CODIGO"];?>" <?=$selected?>><?=$prestacion["CODIGO"];?></option>
                                    <?php
	                            }
	                            ?>
                            </select>
                    </div>
                </div>
                    <div class="col-3">
                        <label>Filtrar por Nombre</label>
                        <div>
                            <select name="nombre" class="selectpicker selectField" placeholder='Seleccione nombre' data-live-search='true'>
                                <option value=""></option>
                                <?php
	                            foreach ($prestaciones as $prestacion){
                                    $selected = $prestacion["NOMBRE"] == $_GET["nombre"] ? "selected" : "";
                                    ?>
                                    <option value="<?=$prestacion["NOMBRE"];?>" <?=$selected?>><?=$prestacion["NOMBRE"]?></option>
                                    <?php
	                            }
	                            ?>
                            </select>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="btn-group float-right ml-3">
                    <a href="<?=base("/prestaciones/new");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>
                </div>

                <div class="btn-group float-right">
	            	<?php
	            	if(!empty($_GET["codigo"]) || !empty($_GET["nombre"])){
	            		?>
                        <a class="btn btn-default" href="<?=base("/prestaciones/");?>">Limpiar Filtros</a>
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
            <div class="table table-sm table-bordered table-hover nowrap">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Valor Nivel 1</th>
                            <th>Valor Nivel 2</th>
                            <th>Valor Nivel 3</th>
                            <th>FONASA</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    	<?php
                    	foreach ($listaPrestaciones as $index => $prestaciones) {
                    	?>
                            <tr>
                                <td> <?= $prestaciones["CODIGO"]; ?></td>
                                <td> <?= $prestaciones["NOMBRE"] ?></td>
                                <td> <?= $prestaciones["VALOR_NIVEL_1"] ?></td>
                                <td> <?= $prestaciones["VALOR_NIVEL_2"] ?></td>
                                <td> <?= $prestaciones["VALOR_NIVEL_3"] ?></td>
                                <td> <?= $prestaciones["FONASA"] ?></td>
                                <td>
                                    <?php if(!$proveedores["FECHA_ELIMINACION"]){ ?>
                                        <a href="<?=base("/prestaciones/new?id=").$prestaciones["CODIGO"];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                                        <a href="#" data-target="#miModal<?=$index;?>" data-toggle="modal" class="btn btn-danger btn-xs"  ><i class="far fa-trash-alt"></i> Eliminar</a>
                                        <!-- modal starts -->
                                        <div class="modal fade" id="miModal<?= $index; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/prestaciones/delete?id=").$prestaciones["CODIGO"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar <?= $prestaciones["NOMBRE"];?></h4>
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
                                        <!-- modal starts -->
                                        <!-- <div class="modal fade" id="deleteModal<?=$prestaciones["CODIGO"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1>Información Contacto</h1>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form class="form-horizontal" method="post" action="<?=base("/proveedores/delete?id=").$proveedores["ID"];?>" >
                                                    
                                                            <div class="modal-body">
                                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>NOMBRE</th>
                                                                            <th>TELÉFONO</th>
                                                                            <th>EMAIL</th>
                                                                        </tr>
                                                                        
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><?=$proveedores["NOMBRE"];?></td>
                                                                            <td><?=$proveedores["TELEFONO"];?></td>
                                                                            <td><?=$proveedores["EMAIL"];?></td>
                                                                        </tr>
                                                                    
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-default">Continuar</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                            </div>
                                                        
                                                    </div>

                                                    
                                                    </form>
                                                </div>
                                            </div>
                                        </div>  -->
                                        <!-- modal ends -->
                                    <?php
                                }else{
                                	?>
                                        <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal<?=$prestaciones["CODIGO"];?>" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a>

                                        <!-- modal starts -->
                                        <div class="modal fade" id="restoreModal<?=$prestaciones["CODIGO"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/prestaciones/new?restore=true&id=").$prestaciones["CODIGO"];?>" >

                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Restaurar  <?=$prestaciones["NOMBRE"];?> </h4>
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
                                        <div class="modal fade" id="forceDeleteModal<?=$prestaciones["CODIGO"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/prestaciones/delete?force=true&id=").$prestaciones["CODIGO"];?>" >
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> Borrar permanentemente <?=$prestaciones["NOMBRE"];?> </h4>
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
        	<?=paginador($totales, "/newcyc/prestaciones");?>
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