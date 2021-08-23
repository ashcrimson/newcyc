<?php
 


namespace OrdenCompraShow;

/** 
 * controlador de vista
 */
class ControllerOrdenCompraShow {
	
	//hace nada c:
	public function show(ModelOrdenCompraShow $model){
        return $model;
	}

	public function anula(\OrdenCompraShow\ModelOrdenCompra $model){
		if(isset($_GET["nro_orden_compra"])){
			$model = $model->anula($_GET["nro_orden_compra"]);
		}
		return $model;
	}


}