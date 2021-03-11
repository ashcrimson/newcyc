<?php



namespace OrdenCompraNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewOrdenCompra {

	public function output(\OrdenCompraNew\ModelOrdenCompra $model){


        if(isset($_GET["nro_orden_compra"])){
			$registroEdit = $model->get();

        }


        $dataContratos = $model->getContratos();

		ob_start();

		?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=base("/ordenCompra");?>" class="encabezado">Orden de Compra</a>
            </li>
            <!-- <li class="breadcrumb-item active">Mantenedor</li> -->
        </ol>

        <?php feedback2();?>

        <div class="card mb-3" id="root">
            <form method="post" class="form-horizontal" action="<?=base();?>/ordenCompra/save" enctype="multipart/form-data">
                <div class="card-body">


                    <!--            Encabezado
                    ------------------------------------------------------------------------>
                    <div class="row">
                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                            <label>
                                ID Contrato
                                <i class="fa fa-spinner fa-spin " v-show="buscandoDetalles"></i>
                            </label>
                            <multiselect
                                v-model="contrato"
                                :options="contratos"
                                :close-on-select="true"
                                :show-labels="false"
                                placeholder="Seleccione un contrato..."
                                track-by="id"
                                label="nombre"
                                @input="getDetallesContrato"
                            >

                            </multiselect>
                            <input type="hidden" name="id" value="<?=isset($_GET["nro_orden_compra"]) ? $_GET["nro_orden_compra"]: "" ?>" >
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4" id="nro_orden_compra">
                            <label>Número Orden de Compra * </label>

                            <!-- <input type="text" name="numeroOrdenCompra"  class="form-control" value="{{ $ordenCompraData->numeroOrdenCompra ?: old('numeroOrdenCompra') }}"> -->
                            <input type="text" name="nro_orden_compra"  class="form-control"
                                   required id="nro_orden_compra"
                                   value="<?= $_GET["nro_orden_compra"] ?? $registroEdit['NRO_ORDEN_COMPRA'] ?>">

                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                            <label>Fecha de Envío</label>

                            <input type="date" name="fecha_envio" class="form-control"
                                   value="<?=$_GET["fecha_envio"] ??  fechaEn($registroEdit['FECHA_ENVIO']) ?? ''?>" required>
                        </div>

                        <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
                            <label>Estado *</label>
                            <multiselect
                                    v-model="estado"
                                    :options="estados"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    placeholder="Seleccione un..."
                            >

                            </multiselect>

                        </div>


                        <div class="form-group has-feedback col-xsñ-4 col-md-4 col-lg-4">
                            <label for="">Adjuntar Orden de Compra</label>
                            <div class="custom-file">
                                <input type="file" name="archivo_orden_compra" class="custom-file-input" id="customFileLangHTML" lang="es" >
                                <label class="custom-file-label" for="customFileLangHTML" data-browse="Buscar">Seleccionar Archivo</label>
                            </div>
                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                            <label>¿Agregar detalles de Contrato?</label>
                            <input type="hidden" name="submit" value="true">
                            <multiselect
                                    v-model="agregar_detalles"
                                    :options="agregar_detalles_options"
                                    :close-on-select="true"
                                    :show-labels="false"
                                    placeholder="Seleccione un..."
                            >

                            </multiselect>

                        </div>

                        <div class="form-group has-feedback col-xs-12 col-md-12 col-lg-12 " id="descripcion">
                            <label>Descripción Orden de Compra</label>

                            <textarea name="descripcion" class="form-control" rows="2"><?=$_GET["descripcion"] ?? $registroEdit['DESCRIPCION'] ?></textarea>

                        </div>

                        <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 " v-show="!puedeAgregarDetalles">
                            <label>Monto </label>

                            <input type="text" name="total"   class="form-control" required
                                   value="<?= $_GET["total"] ?? $registroEdit['TOTAL']  ?? 0?>">

                        </div>

                    </div>



                    <!--            Detalles
                    ------------------------------------------------------------------------>
                    <div class="row" v-show="puedeAgregarDetalles" >
                        <div class="col-sm-12">
                            <div class="card card-outline card-success">
                                <div class="card-header pb-1">
                                    <h5 class="card-title">Detalles</h5>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Saldo</th>
                                            <th>Precio</th>
                                            <th>Sub Total</th>
                                            <th>Agregar</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-for="(det,index) in detalles">
                                            <td v-text="det.nombre"></td>
                                            <td v-text="det.cantidad"></td>
                                            <td v-text="det.saldo"></td>
                                            <td v-text="det.precio"></td>
                                            <td v-text="det.precio*det.cantidad"></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" role="button" @click.prevent="removeDet(index,det)">Eliminar</button>
                                            </td>
                                        </tr>

                                        <tr v-if="detalles.length == 0">
                                            <td colspan="10" class="text-center text-warning">No hay ningún detalles agregado</td>
                                        </tr>


                                        <tr id="filaNuevoDetalle">
                                            <td width="45%">
                                                <multiselect
                                                        v-model="item"
                                                        :options="items"
                                                        :close-on-select="true"
                                                        :show-labels="false"
                                                        :placeholder="placeholderSelectItem"
                                                        track-by="id"
                                                        label="nombre"
                                                >
                                                </multiselect>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="item.cantidad" id="cantidad" >
                                            </td>

                                            <td>
                                                <input type="text" class="form-control" readonly :value="item.saldo">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"  readonly :value="item.precio">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" readonly :value="subTotalDet(item)">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success"  @click.prevent="addDet()">Agregar</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th class="text-right" >
                                                <span v-text="total"></span>
                                            </th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>


                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-8">
                            <input type="hidden" name="detalles" :value="JSON.stringify(detalles, null, 3)">
                            <button type="submit" class="btn-primary btn rounded" name="submit" value="1" >
                                <i class="icon-floppy-disk"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>





        <script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
        <script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
        <script src="<?=base();?>/assets/assets/vendor/vue.js"></script>
        <script src="<?=base();?>/assets/assets/vendor/vue.js"></script>
        <script src="<?=base();?>/assets/assets/vendor/vue-multiselect.min.js"></script>


        <script>



            var vm = new Vue({
                el: '#root',
                mounted() {
                    console.log('Instancia vue montada');
                },
                components: {
                    Multiselect: window.VueMultiselect.default
                },
                created() {
                    this.getDetallesContrato();
                    console.log('Instancia vue creada');
                },
                data: {
                    item: '',
                    items : [],
                    contrato: null,
                    contratos: <?=json_encode($dataContratos)?>,

                    estado: '',
                    estados: ['Aceptada','Pendiente','Recepcion Conforme'],

                    agregar_detalles: '',
                    agregar_detalles_options: ['Sí','No'],

                    detalles: [],
                    buscandoDetalles: false
                },
                methods: {
                    async getDetallesContrato(){

                        if (this.contrato){
                            console.log("get detalles contrato id: ",this.contrato.id);

                            this.items = [];
                            this.buscandoDetalles = true;

                            let url = '<?=base()."/get/detalles/contratos/ajax";?>';

                            try {
                                let res = await axios.get(url,
                                    {
                                        params: {
                                            id: this.contrato.id
                                        }
                                    }
                                );

                                this.items = res.data || [];

                                console.log(res);
                                this.buscandoDetalles = false;

                            }catch (e) {

                                console.log(e);
                                this.buscandoDetalles = false;
                            }
                        }
                    },
                    addDet(){
                        var newDet = Object.assign({}, this.item);


                       if(this.item.cantidad <= 0){

                           alert('La cantidad debe ser mayor a 0');
                           $("#cantidad").focus().select();
                           return
                       }

                       if(this.item.cantidad > this.item.saldo){

                           alert('La cantidad no  puede ser mayor al saldo');
                           $("#cantidad").focus().select();
                           return
                       }


                        newDet.saldo = parseFloat(newDet.saldo)-parseFloat(newDet.cantidad);
                        this.item.saldo = parseFloat(this.item.saldo)-parseFloat(this.item.cantidad);

                        this.detalles.push(newDet);
                    },
                    removeDet(index,detalle){
                        this.item.saldo += parseFloat(detalle.cantidad);
                        this.detalles.splice(index,1);
                    },
                    subTotalDet(item){
                        var sub = 0;

                        if (item.cantidad && item.precio){
                            sub = item.cantidad * item.precio;
                        }

                        return sub;
                    }
                },
                computed: {
                    hayItems(){
                        return this.items.length > 0;
                    },
                    puedeAgregarDetalles(){
                        return this.agregar_detalles=='Sí' ? true : false;
                    },
                    placeholderSelectItem(){

                        if (this.contrato){
                            return this.hayItems ? "Seleccione un artículo..." : "El contrato no tiene artículos";
                        }

                        return this.hayItems ? "Seleccione un artículo..." : "Seleccione un contrato";
                    },
                    total(){
                        return 0
                    }
                }
            });





        </script>




        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
//		return "";

    }
}