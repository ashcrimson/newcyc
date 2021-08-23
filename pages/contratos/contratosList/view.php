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


        $queryString = $_SERVER['QUERY_STRING'] ?? '';

        $id = $_GET['id'] ?? 0;

        if($id){
            $search= 'id='.$id;
            $queryString = str_replace($search,'',$queryString);
        }

        $queryString = $queryString!='' ? '&'.$queryString : '';


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
            <a href="<?=base();?>/contratos" class="encabezado">Contratos</a>
        </li>
        
    </ol>

        <?php feedback2();?>

        <!-- DataTables Example -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
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

                        <!-- <div class="col-md-3 col-sm-12">
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

                        <div class="col-md-3 col-sm-12">
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

                        <?php if($authUser['ID_PERMISO']== 1)
                        {
                            ?>

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
                        <?php
                        }
                        ?>



                        <div class="col-md-3 col-sm-12 mt-3" style="margin-top:0 !important;">
                            <label>Vigencia Contrato</label>
                            <div>
                                <select name="vigencia" class="selectpicker selectField" placeholder='Seleccione Vigencia' data-live-search='true'>
                                    <option value=""></option>
                                    <option value="si">Vigente</option>
                                    <option value="no">No vigente</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 mt-3" style="margin-top:0 !important;">
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

                        <!-- <div class="col-md-3 col-sm-12 mt-3">
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
                        </div> -->
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


                </form>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <span>
                    <i class="fas fa-table"> Registros</i>
                </span>
                <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover nowrap" id="tablaContratos">
                    <thead>
                    <tr >
                        <!-- <th data-priority="1">ID Contrato</th> -->
                        <th data-priority="1">ID Mercado Público</th>
                        <th data-priority="100001">Rut Proveedor</th>
                        <th data-priority="1" width="20%">Razón Social Proveedor</th>
                        <th data-priority="3">Licitación</th>
                        <th data-priority="100001">Moneda</th>
                        <!-- <th data-priority="5">Precio</th> -->
                        <!-- <th data-priority="100001">Restante</th> -->
                        <th data-priority="100001">Cargo</th>
                        <th data-priority="100001">Fecha inicio contrato</th>
                        <th data-priority="100001">Fecha termino contrato</th>
                        <th data-priority="100001">Fecha último acto administrativo</th>
                        <th data-priority="100001">Objeto del contrato</th>
                        <th data-priority="100001">N° Boleta Garantía</th>
                        <th data-priority="1">Monto</th>
                        <th data-priority="100001">Valor CLP</th>
                        <th data-priority="1">Saldo</th>
                        <th data-priority="100001">Fecha Alerta de Vencimiento</th>
                        <th data-priority="100001">Fecha Vencimiento Boleta</th>
                        <th data-priority="100001">Adjunto</th>
                        <th data-priority="100001">Creado por</th>
                        <th data-priority="100001">Actualizado por</th>

                        <th width="25%">Acciones</th>
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
                        ?>
                        <tr class="text-sm">

                            <!-- <td ><?= $contrato["TIPO"] ."-". $contrato["ID_CONTRATO"]; ?></td> -->
                            <td ><?= $contrato["ID_MERCADO_PUBLICO"]; ?></td>
                            <td ><?= $contrato["RUT_PROVEEDOR"]; ?></td>
                            <td><?= $contrato["RAZON_SOCIAL"]; ?></td>

                            <td ><?= $contrato["NRO_LICITACION"]; ?></td>
                            <td><?= $contrato["NOMBRE_MONEDA"]; ?></td>
                            <!-- <td><?= $contrato["PRECIO"]; ?></td> -->

                            <!-- <td><?= $contrato["RESTANTE"];?></td> -->
                            <td><?= $contrato["NOMBRE_CARGO"];?></td>
                            <td><?= $contrato["FECHA_INICIO"]; ?></td>
                            <td><?= $contrato["FECHA_TERMINO"]; ?></td>
                            <td><?= $contrato["FECHA_APROBACION"]; ?></td>
                            <td><?= $contrato["OBJETO_CONTRATO"]; ?></td>
                            <td><?= $contrato["NRO_BOLETA_GARANTIA"]; ?></td>
                            <td>$<?= number_format($contrato["MONTO"], 2, ',', '.') ?></td>
                            <td>$<?= number_format($contrato["MONTO"] * $contrato["EQUIVALENCIA"], 2, ',', '.'); ?></td>
                            <td>$<?= number_format($contrato["SALDO"], 2, ',', '.') ?></td>
                            <td><?= $contrato["FECHA_ALERTA_VENCIMIENTO"]; ?></td>
                            <td><?= $contrato["FECHA_VENCIMIENTO_BOLETA"]; ?></td>
                            <td>
                                <a href="<?= base()."/archivo/download?id=".$contrato['NRO_DOCUMENTO'] ?>" target="_blank">
                                    <?= $contrato["NOMBRE_DOCUMENTO"] ?>
                                </a>

                            </td>
                            <td><?= $contrato["USUARIO_CREA"]; ?></td>
                            <td><?= $contrato["USUARIO_ACTUALIZA"]; ?></td>
                            <td>
                                <a href="<?=base("/contratos/bitacora/show?id=").$contrato["ID_CONTRATO"].$queryString;?>"
                                   class="btn btn-sm btn-secondary btn-sm "
                                   data-toggle="tooltip" title="Bitacoras">
                                    <i class="fa fa-book-reader"></i>
                                </a>
                                <?php
                            if($authUser['ID_PERMISO'] == 1) {
                                ?>
                                <a href="<?=base("/contratos/new?id=").$contrato["ID_CONTRATO"];?>"
                                   class="btn btn-sm btn-primary btn-sm"
                                   data-toggle="tooltip" title="Editar">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <?php
                            }
                            ?>
                                <a href="<?=base("/contratos/show?id=").$contrato["ID_CONTRATO"].$queryString;?>"
                                   class="btn btn-sm btn-success btn-xs"
                                   data-toggle="tooltip" title="Detalles">
                                    <i class="fa fa-list-ol"></i>
                                </a>

                            </td>


                            <?php
                            if($authUser['ID_PERMISO'] == 2) {
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
                                        echo "Asignado a: ".$contrato['ASIGNADO_A'];
                                    }
                                    ?>
                                </td>
                                <?php
                            }
                            ?>


                        </tr>
                        <?php
                    }
                    ?>
                </table>
                </div>
            </div>
        </div>


<!--        <nav class="d-flex justify-content-center wow fadeIn mt-3">-->
<!--            --><?php
//            paginador($totales, "./contratos", 10);
//            ?>
<!--        </nav>-->

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
	</script>

    <!-- {{-- Script para mostrar nombre archivo en el select --}} -->
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>


        <script>
            $('#tablaContratos').DataTable( {
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Detalles de contrato: '+data[0];
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
                } );

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