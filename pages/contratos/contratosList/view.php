<?php

 
 
namespace ContratosList;


 
/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {

    
	
	public function output(\ContratosList\ModelContratos $model){

        
        $authUser = authUser($model->pdo);

		$data = $model->get();

        //arrays para la tabla principal
		$listado = $data['listado'];
        $totales = $data['totales'];


        $dataListBox = $model->getDataListBox();

        //arrays para los selects
        $proveedores = $dataListBox['proveedores'];
        $contratos = $dataListBox['contratos'];
        $licitaciones = $dataListBox['licitaciones'];
        $cargos = $dataListBox['cargos'];


		ob_start();

		?>




    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/xlsx.full.min.js"></script>
    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/FileSaver.js"></script>
    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/xlsx.core.min.js"></script>
    
    <style>
    .card-body {
        overflow: scroll;
        
    }


    </style>
 
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base();?>/contratos">Contratos</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <!-- DataTables Example --> 
    <div class="container">
        <div >
            <form method="get" class="form-horizontal" action="<?=base("/contratos/")?>">
                
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label>Proveedor</label>
                            <div>
                                <select name="rut_proveedor" class="selectpicker selectField"  placeholder='Seleccione RUT Proveedor' data-live-search='true'>
                                    <option value=""></option>
                                    <?php
                                    foreach ($proveedores as $proveedor) {
                                        $selected = $_GET["rut_proveedor"]==$proveedor["RUT_PROVEEDOR"] ? 'selected' : '';
                                        ?>
                                        <option value="<?= $proveedor["RUT_PROVEEDOR"];?>" <?=$selected?>>
                                            <?= $proveedor["RUT_PROVEEDOR"]." / ".$proveedor["RAZON_SOCIAL"];?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>
 
                    <div class="col-md-3 col-sm-12">
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
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <label>Cargo Admin. Técnico</label>
                            <div>
                                <select name="cargos" class="selectpicker selectField" placeholder='Seleccione Cargo' data-live-search='true'>
                                    <option value=""></option>
                                    <?php 
                                    
                                    foreach ($cargos as $cargo) { 
                                        if (!empty($_GET["cargos"]) && $_GET["cargos"] == $cargo["ID_CARGO"]){
                                            ?>
                                            
                                            <option selected="true" value="<?= $cargo["ID_CARGO"];?>"><?= $cargo["NOMBRE"];?></option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="<?= $cargo["ID_CARGO"];?>"><?= $cargo["NOMBRE"];?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>

                    

                    <div class="col-md-3 col-sm-12 mt-3">
                        <label>Vigencia Contrato</label>
                        <div>
                            <select name="vigencia" class="selectpicker selectField" placeholder='Seleccione Vigencia' data-live-search='true'>
                                <option value=""></option>
                                <option value="si">Vigente</option>
                                <option value="no">No vigente</option>
                            </select>
                        </div> 
                    </div>

		            <div class="col-md-3 col-sm-12 mt-3">
                        <label>Licitación</label>
                        <div>
                            <select name="licitacion" class="selectpicker selectField" placeholder='Seleccione Licitación' data-live-search='true'>
                                <option value=""></option>
                                <?php 
                                foreach ($licitaciones as $licitacion) { 
                                    if (!empty($_GET["licitacion"]) && $_GET["licitacion"] == $licitacion["NRO_LICITACION"]){
                                        ?>
                                        <option selected="true" value="<?= $licitacion["NRO_LICITACION"];?>"><?= $licitacion["NRO_LICITACION"];?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?= $licitacion["NRO_LICITACION"];?>"><?= $licitacion["NRO_LICITACION"];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 mt-3">
                        <label>Objeto Contrato</label>
                        <div>
                            <select name="objeto" class="selectpicker selectField" placeholder='Seleccione Objeto' data-live-search='true'>
                                <option value=""></option>
                                <?php 
                                foreach ($contratos as $index => $contrato) { 
                                    if (!empty($_GET["objeto"]) && $_GET["objeto"] == $contrato["OBJETO_CONTRATO"]){
                                        ?>
                                        <option selected="true" value="<?= $contrato["OBJETO_CONTRATO"];?>"><?= $contrato["OBJETO_CONTRATO"];?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?= $contrato["OBJETO_CONTRATO"];?>"><?= $contrato["OBJETO_CONTRATO"];?></option>
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
                <?php if($authUser['ID_PERMISO']== 1)
                {
                ?>
                    <a href="<?=base("/contratos/new/");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>         
                <?php
                }
                ?>
        </div>
                <div class="btn-group float-right">
                    <?php if(!empty($_GET)){ ?> 
                        <a class="btn btn-default" href="<?=base()."/contratos";?>">Limpiar Filtros</a>
                    <?php } ?>
                        <button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
                </div>

                <div>
                    <i class="fas fa-table"> Registros</i>
                </div>
            </form>
        </div>

        <div class="container-fluid">
             
            <table class="table table-hover table-responsive">
                <thead>
                    <tr >
                        <th >ID Contrato</th>
                        <th >Rut Proveedor</th>
                        <th >Razón Social Proveedor</th>
                        
                        <th >Licitación</th>
                        <!-- <th >Moneda</th> -->
                        <!-- <th>Precio</th> -->
                        
                        <!-- <th>Restante</th> -->
                        <!-- <th>Cargo</th> -->
                        <!-- <th>Fecha inicio contrato</th> -->
                        <!-- <th>Fecha termino contrato</th> -->
                        <!-- <th>Fecha último acto administrativo</th> -->
                        <!-- <th>Objeto del contrato</th> -->
                        <!-- <th>N° Boleta Garantía</th> -->
                        <!-- <th>Monto</th> -->
                        <!-- <th>Valor CLP</th> -->
                        <th>Saldo</th>
                    
                        <!-- <th>Fecha Alerta de Vencimiento</th> -->
                        <!-- <th>Fecha Vencimiento Boleta</th> -->
                        <!-- <th>Adjunto</th> -->
                        
                        <th>Bitácora</th>
                        <th>Editar</th>
                        <th>Detalle Contrato</th>
                        <th>Más información</th>
                        <?php if($authUser['ID_PERMISO'] == 2) {
                        ?>
                        <th>Asignar Contrato</th>
                        <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <?php
                    foreach ($listado as $index => $contrato) {
                        // foreach ($documentos as $documento) {
                        ?>
                        <tr> 

                            <td ><?= $contrato["TIPO"] ."-". $contrato["ID_CONTRATO"]; ?></td>
                            <td ><?= $contrato["RUT_PROVEEDOR"]; ?></td>
                            <td style="width:1%;"><?= $contrato["RAZON_SOCIAL"]; ?></td>
                            
                            <td ><?= $contrato["NRO_LICITACION"]; ?></td>
                            <!-- <td style="width:1%;"><?= $contrato["NOMBRE_MONEDA"]; ?></td> -->
                            <!-- <td><?= $contrato["PRECIO"]; ?></td> -->
                            
                            <!-- <td><?= $contrato["RESTANTE"];?></td> -->
                            <!-- <td style="width:2%;"><?= $contrato["NOMBRE_CARGO"];?></td> -->
                            <!-- <td style="width:3%;"><?= $contrato["FECHA_INICIO"]; ?></td> -->
                            <!-- <td style="width:3%;"><?= $contrato["FECHA_TERMINO"]; ?></td>  -->
                            <!-- <td style="width:2%;"><?= $contrato["FECHA_APROBACION"]; ?></td> -->
                            <!-- <td style="width:2%;"><?= $contrato["OBJETO_CONTRATO"]; ?></td> -->
                            <!-- <td style="width:1%;"><?= $contrato["NRO_BOLETA_GARANTIA"]; ?></td> -->
                            <!-- <td style="width:1%;">$<?= number_format($contrato["MONTO"], 2, ',', '.') ?></td> -->
                            <!-- <td style="width:1%;">$<?= number_format($contrato["MONTO"] * $contrato["EQUIVALENCIA"], 2, ',', '.'); ?></td> -->
                            <td >$<?= number_format($contrato["SALDO"], 2, ',', '.') ?></td>
                            <!-- <td style="width:1%;">$<?= number_format($contrato["MONTO"] - $contrato["TOTAL"], 2, ',', '.'); ?></td> -->

                            <!-- <td style="width:2%;"><?= $contrato["FECHA_ALERTA_VENCIMIENTO"]; ?></td> -->
                            <!-- <td style="width:2%;"><?= $contrato["FECHA_VENCIMIENTO_BOLETA"]; ?></td> -->
                            <!-- <td style="width:1%;">
                                <a href="<?= base()."/archivo/download?id=".$contrato['NRO_DOCUMENTO'] ?>" target="_blank">
                                    <?= $contrato["NOMBRE_DOCUMENTO"] ?>
                                </a>
                            </td> -->

                            <td >
                                <a href="<?=base("/contratos/bitacora/show?id=").$contrato["ID_CONTRATO"];?>" class="btn btn-sm btn-success btn-xs">
                                    <i class="fa fa-pencil-alt"></i> Bitacoras
                                </a>

                                   </div>
                               </div>




                            </td>
                            <td >
                                <a href="<?=base("/contratos/new?id=").$contrato["ID_CONTRATO"];?>" class="btn btn-sm btn-primary btn-xs">
                                    <i class="fa fa-pencil-alt"></i> Editar
                                </a>
                            </td>
                            <td >
                                <!-- <a href="#" data-target="#miModal<?=$index;?>" data-toggle="modal" class="btn btn-sm btn-success btn-xs">
                            <i class="fa fa-book-open"></i> Detalle</a>
 -->
                <a href="<?=base("/contratos/show?id=").$contrato["ID_CONTRATO"];?>" class="btn btn-sm btn-success btn-xs">
                    <i class="fa fa-pencil-alt"></i> Detalles
                </a>

            </td>
            <td >
                <a href="<?=base("/contratos/new?id=").$contrato["ID_CONTRATO"];?>" class="btn btn-sm btn-primary btn-xs">
                    <i class="fa fa-eye"></i> Ver
                </a>
            </td>
                            

                    <?php if($authUser['ID_PERMISO'] == 2) {
                    ?>
                    <td >
                    <?php
                        if(!$contrato['ASIGNADO']) {
                            ?>

                            <a href="#" class="btn btn-sm btn-warning btn-xs" data-target="#modalAsigna<?=$index;?>" data-toggle="modal">
                                <i class="fa fa-plus-square"></i> Asignar
                            </a>

                            <div class="modal fade" id="modalAsigna<?=$index;?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post" action="<?=base("/contratos/asignar/store");?>">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Asignar Contrato
                                                </h5>
                                            </div>


                                            <div class="modal-body">
                                                <div class="table-responsive table-sm -md -lg -x">
                                                    <?php
                                                        foreach ($contrato['AREAS'] as $i => $area) {

                                                            ?>
                                                            <input type="radio" id="radio<?=$i?>" name="area" value="<?=$area['ID_AREA'];?>">
                                                            <label for="radio<?=$i?>"><?=$area['AREA'];?></label><br>
                                                            <?php
                                                        }
                                                    ?>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Cancelar
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-floppy-o"></i>
                                                    Guardar
                                                </button>
                                                <input type="hidden" name="asignar" value="1">
                                                <input type="hidden" name="id_contrato" value="<?=$contrato['ID_CONTRATO']?>">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            echo "asignado";
                        }
                    } 
                    else {
                        echo "";
                        } 
                    ?>
                    </td>


                </tr>
                <?php
                // }
            }
            ?>
            </table>
        </div>

        

        <div class="card-footer">
            <?php
            paginador($totales, "./contratos", 10);
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
	</script>

<!-- {{-- Script para mostrar nombre archivo en el select --}} -->
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

    



		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}