<?php



namespace ContratosList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(\ContratosList\ModelContratos $model){

		$data = $model->get();

		$contratos = $data[5];
        $proveedores = $data[1];
        $cargos = $data[2];
        $licitaciones = $data[3];
		$totales = $data[4];
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
                <!-- {!! csrf_field() !!} -->

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
                                foreach ($contratos as $contrato) { 
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
                        <a class="btn btn-default" href="<?base("/contratos")?>">Limpiar Filtros</a>
                        <button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i> Buscar</button>
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
                    <th>Precio</th>
                    <th>Valor CLP</th>
                    <th>Restante</th>
                    <th>Cargo</th>                    
                    <th>Fecha inicio contrato</th>
                    <th>Fecha termino contrato</th>
                    <th>Fecha último acto administrativo</th>
                    <th>Objeto del contrato</th>
                    <th>N° Boleta Garantía</th>
                    <th>Monto</th>
                    <th>Fecha de Vencimiento</th>
                    <!-- @role('Admin')
                        <th>Acción</th>
                    @endrole -->
                </tr>
                </thead>
                    <?php 
                    foreach ($contratos as $contrato) {
                        ?>
                    <tr>
                        <td><?= $contrato["RUT"]; ?></td>
                        <td><?= $contrato["RAZON"]; ?></td>
                        <td><?= $contrato["TIPO"] ."-". $contrato["ID"]; ?></td>
                        <td><?= $contrato["NRO_LICITACION"]; ?></td>
                        <td><?= $contrato["MONEDA"]; ?></td>
                        <td><?= $contrato["PRECIO"]; ?></td>
                        <td><?= $contrato["PRECIO"] * $contrato["EQUIVALENCIA"]; ?></td>
                        <td><?= $contrato["RESTANTE"];?></td>
                        <td><?= $contrato["CARGO"];?></td>
                        <td><?= $contrato["FECHA_INICIO"]; ?></td>
                        <td><?= $contrato["FECHA_TERMINO"]; ?></td>
                        <td><?= $contrato["FECHA_ACTUALIZACION"]; ?></td>
                        <td><?= $contrato["DETALLE"]; ?></td>
                        <td><?= $contrato["BOLETA"]; ?></td>
                        <td><?= $contrato["MONTO"]; ?></td>
                        <td><?= $contrato["FECHA_ALERTA_VENCIMIENTO"]; ?></td>
                        
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
            paginador($totales, base() . "/contratos", 10);
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