<?php

 
 
namespace ContratosList;
 
/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewContratos {
	
	public function output(\ContratosList\ModelContratos $model){

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

    .table-responsiva{
        width: 230%;
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
    <div class="card mb-3">
        <div class="card-header">
            <form method="get" class="form-horizontal" action="<?=base("/contratos/")?>">
                
                <div class="row">
                    <div class="col-6">
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

                    <div class="col-3">
                        <label>ID Contrato</label>
                            <div>
                                <select name="id_contrato" class="selectpicker selectField" placeholder='Seleccione Contrato' data-live-search='true'>
                                    <option value=""></option>
                                    <?php 
                                    foreach ($contratos as $contrato) {
                                        $selected = $_GET["id_contrato"]==$contrato["ID_CONTRATO"] ? 'selected' : '';
                                        ?>
                                            <option value="<?= $contrato["ID_CONTRATO"];?>" <?=$selected?>>
                                                <?= $contrato["ID_CONTRATO"];?>
                                            </option>
                                        <?php
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
                <div class="btn-group float-right ml-3">
                    <a href="<?=base("/contratos/new/");?>" class="btn btn-primary rounded"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Nuevo</a>         
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

        <div class="card-body">

            
            <table class="table table-bordered table-responsiva table-fixed" id="dataTable" >
                <thead>
                <tr >
		            <th >Rut Proveedor</th>
                    <th >Razón Social Proveedor</th>
                    <th >ID Contrato</th>
                    <th >Licitación</th>
                    <th >Moneda</th>
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
                    <th>Editar</th>
                    <th>Detalle Contrato</th>
                </tr>
                </thead>
                    <?php 
                    foreach ($listado as $index => $contrato) {
                        // foreach ($documentos as $documento) {
                        ?>
                    <tr>

                        
                        <td style="width:2%;"><?= $contrato["RUT_PROVEEDOR"]; ?></td>
                        <td style="width:7%;"><?= $contrato["RAZON_SOCIAL"]; ?></td>
                        <td style="width:1%;"><?= $contrato["TIPO"] ."-". $contrato["ID_CONTRATO"]; ?></td>
                        <td style="width:6%;"><?= $contrato["NRO_LICITACION"]; ?></td>
                        <td style="width:1%;"><?= $contrato["ID_MONEDA"]; ?></td>
                        <!-- <td><?= $contrato["PRECIO"]; ?></td> -->
                        <!-- <td><?= $contrato["PRECIO"] * $contrato["EQUIVALENCIA"]; ?></td> -->
                        <!-- <td><?= $contrato["RESTANTE"];?></td> -->
                        <td style="width:2%;"><?= $contrato["ID_CARGO"];?></td>
                        <td style="width:3%;"><?= $contrato["FECHA_INICIO"]; ?></td>
                        <td style="width:3%;"><?= $contrato["FECHA_TERMINO"]; ?></td>
                        <td style="width:2%;"><?= $contrato["FECHA_APROBACION"]; ?></td>
                        <td><?= $contrato["OBJETO_CONTRATO"]; ?></td>
                        <!-- <td><?= $contrato["BOLETA"]; ?></td> -->
                        <td>$<?= number_format($contrato["MONTO"], 2, ',', '.') ?></td>
                        <td style="width:2%;"><?= $contrato["FECHA_ALERTA_VENCIMIENTO"]; ?></td>
                        <td>
                            <a href="<?= base()."/archivo/download?id=".$contrato['NRO_DOCUMENTO'] ?>" target="_blank">
                                <?= $contrato["NOMBRE_DOCUMENTO"] ?>
                            </a>
                        </td>
                  
                        <td style="width:2%;">
                            <a href="#" class="btn btn-info btn-xs" data-target="#deleteModal<?=$contrato['ID_CONTRATO'];?>" data-toggle="modal">
                                <i class="far fa-eye"></i> Bitacora
                            </a>

                            <!-- modal starts -->
                            <div class="modal fade" id="deleteModal<?=$contrato['ID_CONTRATO'];?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">


                                        <form method="post" action="<?=base("/contratos/bitacora/store");?>"  enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Bitacoras
                                                </h5>
                                            </div>

                                            <div class="table-responsive table-sm -md -lg -x tabla-bitacora">
                                                <table class="table table-bordered"  class="table-sm w-25" id="dataBitacoras" width=100% cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID Contrato</th>
                                                            <th>Glosa</th>
                                                            <th>Documento</th>
            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($contrato['BITACORAS'] as $bitacora){?>
                                                             <tr>
                                                             <td> <?= $bitacora["ID_CONTRATO"]; ?></td>
                                                             <td> <?= $bitacora["GLOSA"]; ?></td>
                                                             
                                                             <td>
                                                                <a href="<?= base()."/archivo/download?id=".$bitacora['NRO_DOCUMENTO'] ?>" target="_blank">
                                                                    <?= $bitacora["DOCUMENTO"] ?>
                                                                </a>
                                                            </td>
                                                             
                                                             
                                                             
                                                         </tr>
                                                       <?php }?>
                                                       
                                                          
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label for="">Adjuntar archivo bitácora.</label>
                                                        <div class="custom-file">
                                                            <input type="file" name="archivo_bitacora" class="custom-file-input" id="customFileLangHTML" lang="es">
                                                            <label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label>Comentarios *</label>
                                                        <textarea type="text" name="glosa" class="form-control" value="" ></textarea>
                                                        <input type="hidden" name="id_contrato" value="<?=$contrato['ID_CONTRATO']?>">
                                                        <input type="hidden" name="save_bitacora" value="1">
                                                    </div>
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
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- modal starts -->
                            <div class="modal fade" id="miModal<?= $index; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content contento">

                                    <form method="post" action="<?=base("/contratos/bitacora/store");?>"  enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Detalle Contrato
                                            </h5>
                                        </div>

                                        <div class="table-responsive table-sm -md -lg -x">
                                            <table class="table table-bordered"  class="table-sm w-25" id="dataBitacoras" width=100% cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>DESC_PROD_SOLI</th>
                                                        <th>CANTIDAD TOTAL</th>
                                                        <th>PRECIO_U_BRUTO</th>
                                                        <th>GRUPO</th>
                                                        <th>PRESENTACION_PROD_SOLI</th>
                                                        <th>F_F</th>
                                                        <th>DESC_TEC_PROD_OFERTADO</th>
                                                        <th>U_ENTREGA_OFERENTE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($contrato["DETALLES"] as  $detalle){?>
                                                            <tr>
                                                            
                                                                <td> <?= $detalle["CODIGO"]; ?></td>
                                                                <td> <?= $detalle["DESC_PROD_SOLI"]; ?></td>
                                                                <td> <?= $detalle["CANTIDAD_TOTAL"]; ?></td>
                                                                <td> <?= $detalle["PRECIO_U_BRUTO"]; ?></td>
                                                                <td> <?= $detalle["GRUPO"]; ?></td>
                                                                <td> <?= $detalle["PRESENTACION_PROD_SOLI"]; ?></td>
                                                                <td> <?= $detalle["F_F"]; ?></td>
                                                                <td> <?= $detalle["DESC_TEC_PROD_OFERTADO"]; ?></td>
                                                                <td> <?= $detalle["U_ENTREGA_OFERENTE"]; ?></td>
                                                            </tr>
                                                    <?php }?>
                                                    
                                                        
                                                </tbody>
                                            </table>
                                        </div>

                            </div> 
                            <!-- modal ends -->
                        </td>
                        <td style="width:2%;">
                            <a href="<?=base("/contratos/new?id=").$contrato["ID_CONTRATO"];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i> Editar</a>
                        </td>
                        <td style="width:2%;">
                            <!-- <a href="#" data-target="#miModal<?=$index;?>" data-toggle="modal" class="btn btn-success btn-xs"><i class="fa fa-book-open"></i> Detalle</a> -->
                            <a href="<?=base("/contratos/show?id=").$contrato["ID_CONTRATO"];?>" class="btn btn-success btn-xs"><i class="fa fa-pencil-alt"></i> Detalles</a>

                        </td>


                    </tr>
                        <?php
                        // }
                    }
                    ?>
                      
                </tbody>
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

<script>
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}

</script>
    



		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}