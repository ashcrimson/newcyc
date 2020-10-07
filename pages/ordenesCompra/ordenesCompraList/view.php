<?php



namespace OrdenCompraList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewOrdenCompra {
	
	public function output(\OrdenCompraList\ModelOrdenCompra $model){

		$data = $model->get();

		$listaLicitaciones = $data[0];
		$numerosLicitaciones = $data[1];
		$totales = $data[2];
/*
		//salida a mostrar
		$output = "";
		//picker con todos los numeros de licitacion
		$picker = "";
		//licitaciones filtradas
		$licitaciones = "";


		//genera boton limpieza de filtros
		if(!empty($_GET)){
			$btnEmpty = "<a class=\"btn btn-default\" href=\"./licitaciones\">Limpiar Filtros</a>";
		}else{
			$btnEmpty = "";
		}

		foreach ($numerosLicitaciones as $licitacion) {
			if (isset($_GET["nro_licitacion"]) && $_GET["nro_licitacion"]  == $licitacion["NRO_LICITACION"] ){
				$selected = "selected='true'";
			}else{
				$selected = "";
			}
			$picker .= "<option $selected value=\"" . $licitacion["NRO_LICITACION"] . "\">" . $licitacion["NRO_LICITACION"] . "</option>\n";
		}

		foreach ($listaLicitaciones as $licitacion) {
			$licitaciones .=  "<tr><td>" . $licitacion["NRO_LICITACION"] . "</td>";
			$licitaciones .=  "<td>" . $licitacion["PRESUPUESTO"] . "</td>";
			$licitaciones .=  "<td>" . $licitacion["DETALLE"] . "</td>";
			if ($licitacion["NRO_DOCUMENTO"] ==  null && empty($licitacion["NRO_DOCUMENTO"])){
				$licitaciones .= "<td> N/A </td></tr>";
			}else{
				$licitaciones .= "<td><a target=\"_blank\" href=\"./licitaciones\">Visualizar</a> </td></tr>";
			}
		}
*/
		ob_start();

		?>
























    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/xlsx.full.min.js"></script>
    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/FileSaver.js"></script>
    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/xlsx.core.min.js"></script>
    
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base("/ordenCompra");?>">Orden de Compra</a>
        </li>        
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
            <div class="card-header">
                <form method="get" class="form-horizontal" action="<?= base("/ordenCompra");?>">

                    <div class="row">
                        <div class="col-3">
                            <label>ID Contrato</label>
                            <div>
                            	<!-- por alguna razon esta se llama licitacion internamente pero en realidad es el contrato ¬.¬' -->
                            	<!-- se mantiene solo para mantener interoperabilidad entre sistema antiguo y nuevo si es que alguien hizo un marcador -->
                                <select name="numeroLicitacion" class="selectpicker selectField" placeholder='Seleccione ID Contrato' data-live-search='true'>
                                    <option value=""></option>
	                                <?php 
	                                foreach ($licitaciones as $licitacion) { 
	                                    if (!empty($_GET["numeroLicitacion"]) && $_GET["numeroLicitacion"] == $contrato["NRO_LICITACION"]){
	                                        ?>
	                                        <option selected="true" value="<?= $contrato["NRO_LICITACION"];?>"><?= $contrato["NRO_LICITACION"];?></option>
	                                        <?php
	                                    }else{
	                                        ?>
	                                        <option value="<?= $contrato["NRO_LICITACION"];?>"><?= $contrato["NRO_LICITACION"];?></option>
	                                        <?php
	                                    }
	                                }
	                                ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-3">
                            <label>N° Orden de Compra</label>
                            <div>
                                <select name="numeroOrden" class="selectpicker selectField" placeholder='Seleccione N° Orden de Compra' data-live-search='true'>
                                    <option value=""></option>
	                                <?php 
	                                foreach ($licitaciones as $licitacion) { 
	                                    if (!empty($_GET["numeroOrden"]) && $_GET["numeroOrden"] == $contrato["NRO_LICITACION"]){
	                                        ?>
	                                        <option selected="true" value="<?= $contrato["NRO_LICITACION"];?>"><?= $contrato["NRO_LICITACION"];?></option>
	                                        <?php
	                                    }else{
	                                        ?>
	                                        <option value="<?= $contrato["NRO_LICITACION"];?>"><?= $contrato["NRO_LICITACION"];?></option>
	                                        <?php
	                                    }
	                                }
	                                ?>
                                </select>
                            </div>
                        </div>
                    </div>                                 

                    <div class="row">
                        <div class="col-3">
                            <label>Estado</label>
                            <div>
                                <select name="estado" class="selectpicker selectField" placeholder='Seleccione Estado' data-live-search='true'>
                                    <option value=""></option>
	                                <?php 
	                                foreach ($licitaciones as $licitacion) { 
	                                    if (!empty($_GET["estado"]) && $_GET["estado"] == $contrato["NRO_LICITACION"]){
	                                        ?>
	                                        <option selected="true" value="<?= $contrato["NRO_LICITACION"];?>"><?= $contrato["NRO_LICITACION"];?></option>
	                                        <?php
	                                    }else{
	                                        ?>
	                                        <option value="<?= $contrato["NRO_LICITACION"];?>"><?= $contrato["NRO_LICITACION"];?></option>
	                                        <?php
	                                    }
	                                }
	                                ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--EXPORTAR -->
                   <!-- {{--  <div class="btn-group float-right ml-3" >
                        <a class="btn btn-success rounded" href="{{route('ordenCompra.export')}}"><i class="far fa-file-excel"></i> Exportar</a>
                    </div>           
                    --}} -->
                    <div class="btn-group float-right">
                    <?php if(!empty($_GET)){ ?> 
                        <a class="btn btn-default" href="<?=base("/ordenCompra");?>">Limpiar Filtros</a>
                    <?php } ?>
                        <button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
                    </div>                                                           
                </form>
            </div>

              <div class="card-body">
        <!-- @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status')}}
        </div>
        @endif -->               
    
    <div class="table-responsive">
            <table class="table table-bordered table-sm w-100" id="dataOrdenCompra" cellspacing="0">
                <thead>
                    <tr>
                        
                        <!-- <th>Id Contrato</th> -->
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
               <?php
               foreach ($ordenCompraData as $ordenCompra) {
               		?>
               		<tr>
						<td><?= $ordenCompra["ID"];?></td>
						<td><?= $ordenCompra["NRO_LICITACION"];?></td>
						<td><?= $ordenCompra["NRO_ORDEN_COMPRA"];?></td>
						<td><?= $ordenCompra["FECHA_ENVIO"];?></td>
						<td><?= $ordenCompra["TOTAL"];?></td>
						<td><?= $ordenCompra["ESTADO"];?></td>
						<td><?= $ordenCompra["DOC_ORDNCOMPRA"];?></td>
						<?php
						if($ordenCompra["DOC_ORDNCOMPRA"] == null || $ordenCompra["DOC_ORDNCOMPRA"] == ""){
							?>
							<td>N/A</td>
							<?php
						}else{
							?>
		                    <td>
		                    <a target="_blank" href="<?=$ordenCompra["DOC_ORDNCOMPRA"];?>"> Visualizar</a>
		                   	</td>
							<?php
						}
						?>
						<td>
						<?php
						if($ordenCompra["FECHA_ELIMINACION"] != ""){
							?>	
	                        <a href="#" class="btn btn-danger btn-xs" data-target="#deleteModal<?= $ordenCompra["ID"];?>" data-toggle="modal"> <i class="far fa-trash-alt"></i> Anular</a>
	                      
	                        <!-- modal starts-->
	                        <div class="modal fade" id="deleteModal<?= $ordenCompra["ID"];?>" >
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                <form class="form-horizontal" method="post" action="<?= base("/ordenCompra/?del=true&NRO_ORDEN_COMPRA=") . $ordenCompra["NRO_ORDEN_COMPRA"];?>">
	<!--                                 {!! csrf_field()!!}
	 -->                                <div class="modal-header">
	                                    <h4 class="modal-tittle"> Borrar <?= $ordenCompra["NRO_ORDEN_COMPRA"];?></h4>
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
	<!--                        {{-- <a href="#" class="btn btn-xs btn-succes" data-target="#restoreModal{{ $ordenCompraItem->id }}" data-toggle="modal"><i class="fas fa-arrow-circle-up"></i> Restaurar</a> --}} -->
	                        <!-- modal starts -->
	                    <div class="modal fade" id="restoreModal<?= $ordenCompra["NRO_ORDEN_COMPRA"];?>">
	                        <div class="modal-dialog">
	                            <div class="modal-conent">
	                            <form class="horm-horizontal" method="post" action="<?= base("/ordenCompra/?res=true&NRO_ORDEN_COMPRA=") . $ordenCompra["ID"];?>{{ route('ordenCompra.restore', $ordenCompraItem->id) }}">
	                            <!-- {!! csrf_field() !!} -->
	                            
	                            <div class="modal-header">
	                                <h4 class="modal-tittle"> Restaurar <?= $ordenCompra["NRO_ORDEN_COMPRA"];?></h4>
	                                <button type="buton" class="close" data-dismiss="modal">&times; </button>
	                            </div>

	                            <div class="modal-footer">
	                                <button type="submit" class="btn btn-success"> <!-- {{ trans(' -->Restaurar<!-- ') }} --> </button>
	                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

	                            </div>

	                            </form>

	                            </div>
	                        </div>
	                    </div>
	                    <!-- modal ends-->
	                    
	                    <!-- modal starts-->
	                    <div class="modal fade" id="forceDeleteModal <?= $ordenCompra["NRO_ORDEN_COMPRA"];?>">
	                        <div class="modal-dialog">
	                            <div class="modal-content">
	                            <form class="form-horizontal" method="post" action="<?= base("/ordenCompra/del=true&") . $ordenCompra["NRO_ORDEN_COMPRA"];?>">
	                                <!-- {!! csrf_field() !!} -->
	                                <div class="modal-header">
	                                <h4 class="modal-tittle">Borrar Permanentemente <?= $ordenCompra["NRO_ORDEN_COMPRA"];?></h4>
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
	                    <!-- modal ends-->
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
    </div>
</div> 
    <div class="card-footer">
        <?php
        paginador($totales, base("/ordenCompra"), 10);
        ?>
    </div>
</div>


    <script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
    <script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
    <script>
        $('.selectField').selectize({
            create: false,
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