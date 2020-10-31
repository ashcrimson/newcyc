<?php


 
namespace ContratosList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(\ContratosList\ModelContratos $model){

		$data = $model->get();

        //Forman la tabla
		$listado = $data[0];
        $totales = $data[1];

        //Los select
        $proveedores = $data[2];
        $cargos = $data[3];
        $licitaciones = $data[4];
        $contratos = $data[5];
        $documentos = $data[6];
//print_r($data[1]);

		ob_start();

		?>




    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/xlsx.full.min.js"></script>
    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/FileSaver.js"></script>
    <script lang="javascript" src="<?=base();?>/assets/assets/frontend/js/xlsx.core.min.js"></script>
    
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base();?>/contratos">Contratos</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <form method="get" class="form-horizontal" action="<?=base("/contratos")?>">
                

                <div class="row">
                    <div class="col-3">
                        <label>RUT Proveedor</label>
                        <div>
                            <select name="proveedores" class="selectpicker selectField"  placeholder='Seleccione RUT Proveedor' data-live-search='true'>
                                <option value=""></option>
                                <?php 
                                foreach ($proveedores as $proveedor) { 
                                    if (!empty($_GET["proveedores"]) && $_GET["proveedores"]){
                                        ?>
                                        <option selected="true" value="<?= $proveedor["RUT_PROVEEDOR"];?>"><?= $proveedor["RUT_PROVEEDOR"];?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?= $proveedor["RUT_PROVEEDOR"];?>"><?= $proveedor["RUT_PROVEEDOR"];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label>Razón Social</label>
                        <div>
                            <select name="proveedoresNombre" class="selectpicker selectField" placeholder='Seleccione Razón Social' data-live-search='true'>
                                <option value=""></option>
                                <?php 
                                foreach ($proveedores as $proveedor) { 
                                    if (!empty($_GET["proveedoresNombre"]) && $_GET["proveedoresNombre"] == $proveedor["RUT_PROVEEDOR"]){
                                        ?>
                                        <option selected="true" value="<?= $proveedor["RUT_PROVEEDOR"];?>"><?= $proveedor["RAZON_SOCIAL"];?></option>
                                        <?php
                                    }else{
                                        ?>
                                        <option value="<?= $proveedor["RUT_PROVEEDOR"];?>"><?= $proveedor["RAZON_SOCIAL"];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label>ID Contrato</label>
                        <div>
                            <select name="contratos" class="selectpicker selectField" placeholder='Seleccione Contrato' data-live-search='true'>
                                <option value=""></option>
                                <?php 
                                foreach ($totales as $contrato) { 
                                    if (!empty($_GET["contratos"]) && $_GET["contratos"] == $contrato["ID_CONTRATO"]){
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
                    <div class="col-3 mt-3">
                        <label>Vigencia Contrato</label>
                        <div>
                            <select name="vigencia" class="selectpicker selectField" placeholder='Seleccione Vigencia' data-live-search='true'>
                                <option value=""></option>
                                <option value="si">Vigente</option>
                                <option value="no">No vigente</option>
                            </select>
                        </div>
                    </div>
		    <div class="col-3 mt-3">
                        <label>Licitación</label>
                        <div>
                            <select name="licitacion" class="selectpicker selectField" placeholder='Seleccione licitación' data-live-search='true'>
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
                </div>

                <hr>
                <div class="btn-group float-right">
                    <?php if(!empty($_GET)){ ?> 
                        <a class="btn btn-default" href="./contratos">Limpiar Filtros</a>
                    <?php } ?>
                        <button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
                </div>

                <div>
                    <i class="fas fa-table"> Registros</i>
                </div>
            </form>
        </div>

        <div class="card-body">
<!--             @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif -->
            <!--FILTRAR GRILLA SEGÚN CARGO DE USUARIO. -->
            <div class="table-responsive">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
		            <th>Rut Proveedor</th>
                    <th>Razón Social Proveedor</th>
                    <th>ID Contrato</th>
                    <th>Licitación</th>
                    <th>Moneda</th>
                    <!-- <th>Precio</th> -->
                    <!-- <th>Valor CLP</th> -->
                    <!-- <th>Restante</th> -->
                    <th>Cargo</th>                    
                    <th>Fecha inicio contrato</th>
                    <th>Fecha termino contrato</th>
                    <th>Fecha último acto administrativo</th>
                    <th>Objeto del contrato</th>
                    <!-- <th>N° Boleta Garantía</th> -->
                    <th>Monto</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Adjunto</th>
                    <!-- @role('Admin')
                        <th>Acción</th>
                    @endrole -->
                    <th>Bitácora</th>
                </tr>
                </thead>
                    <?php 
                    foreach ($listado as $contrato) {
                        // foreach ($documentos as $documento) {
                        ?>
                    <tr>
                        <td><?= $contrato["RUT_PROVEEDOR"]; ?></td>
                        <td><?= $contrato["RAZON_SOCIAL"]; ?></td>
                        <td><?= $contrato["TIPO"] ."-". $contrato["ID_CONTRATO"]; ?></td>
                        <td><?= $contrato["NRO_LICITACION"]; ?></td>
                        <td><?= $contrato["ID_MONEDA"]; ?></td>
                        <!-- <td><?= $contrato["PRECIO"]; ?></td> -->
                        <!-- <td><?= $contrato["PRECIO"] * $contrato["EQUIVALENCIA"]; ?></td> -->
                        <!-- <td><?= $contrato["RESTANTE"];?></td> -->
                        <td><?= $contrato["ID_ADMIN"];?></td>
                        <td><?= $contrato["FECHA_INICIO"]; ?></td>
                        <td><?= $contrato["FECHA_TERMINO"]; ?></td>
                        <td><?= $contrato["FECHA_ACTUALIZACION"]; ?></td>
                        <td><?= $contrato["OBJETO_CONTRATO"]; ?></td>
                        <!-- <td><?= $contrato["BOLETA"]; ?></td> -->
                        <td><?= $contrato["MONTO"]; ?></td>
                        <td><?= $contrato["FECHA_ALERTA_VENCIMIENTO"]; ?></td>
                        <td><a href="<?= $contrato['NOMBRE_DOCUMENTO'] ?>"><?= $contrato["NOMBRE_DOCUMENTO"] ?></a></td>
                        
                        <td><a href="#" class="btn btn-primary btn-xs" data-target="#bitacoraModal<?=$contrato["ID_CONTRATO"];?>" data-toggle="modal"><i class="far fa-eye"></i> Ver</a></td>




                         <!-- modal starts -->
                         <div class="modal fade" id="bitacoraModal<?=$contrato["ID_CONTRATO"];?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <form class="form-horizontal" method="post" action="<?=base("/contratos/save/bitacora");?>" >
                                    <input type="hidden" name="id_contrato" value="$contrato['ID_CONTRATO']">
                                        <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
                                            <label for="">Adjuntar archivos</label>
                                                <div class="custom-file">
                                                    <input type="file" name="archivo_contrato" class="custom-file-input" id="customFileLangHTML" lang="es" >
                                                    <label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> 
                            <!-- modal ends -->
                    </tr>
                        <?php
                        // }
                    }
                    ?>
                      
                </tbody>
            </table>
            </div>
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





		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}