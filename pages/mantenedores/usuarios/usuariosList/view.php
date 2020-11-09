<?php




namespace UsuariosList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class viewUsuarios {
	
	public function output(\UsuariosList\ModelUsuarios $model){

		$data = $model->get();

		$usersData = $data[0];
		$numerosUsuarios = $data[1];
		$totales = $data[2];
		ob_start();


		?>




    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/usuarios");?>">Usuarios</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-header">
            <form method="get" class="form-horizontal" action="<?=base("/usuarios");?>">
                <div class="btn-group float-right ml-3">
                    <a href="<?=base("/usuarios/new");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>
                </div>

                <hr>
                

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
                            <th>Nombre</th>
                            <th>E-mail</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody> 
                    	<?php
                    	foreach ($usersData as $users) {
                			?>
                        
                            <tr>
                                <td> <?=$users["NOMBRE"];?></td>
                                <td> <?=$users["MAIL"];?></td>
                                <td>
                                <?php

                                if(!$users["FECHA_ELIMINACION"]) { ?>
                                
                                        <a href="<?=base('/usuarios/new?id=').$users['MAIL'];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-target="#deleteModal<?= $users["MAIL"]; ?>" data-toggle="modal"><i class="far fa-trash-alt"></i> Eliminar</a>

                                        <!-- modal starts -->
                                        <div class="modal fade" id="deleteModal<?= $users["MAIL"]; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base('/usuarios/delete?id=').$users['MAIL'];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar <?=$users["MAIL"];?> </h4>
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
                                        <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal<?=$users['MAIL'];?>" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a>
        

                                        <!-- modal starts -->
                                        <div class="modal fade" id="restoreModal<?=$users["MAIL"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form class="form-horizontal" method="post" action="<?=base("/usuarios/new?restore=true&id=").$users["MAIL"];?>" >

                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Restaurar  <?=$users["NOMBRE"];?> </h4>
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
                                        <div class="modal fade" id="forceDeleteModal<?=$users["MAIL"];?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <form class="form-horizontal" method="post" action="<?=base("/usuarios/delete?force=true&id=").$users["MAIL"];?>" >
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Borrar permanentemente <?=$users["NOMBRE"];?> </h4>
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
	    	paginador($totales, "/usuarios");
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

