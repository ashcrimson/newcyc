<?php
 


namespace OrdenCompraNew;

/** 
 * controlador de vista
 */
class ControllerOrdenCompra {
	
	//hace nada c:
	public function all(\OrdenCompraNew\ModelOrdenCompra $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\OrdenCompraNew\ModelOrdenCompra $model){
		$model->new();
		return $model;
	}

	//solicita edicion de registro
	public function edit(\OrdenCompraNew\ModelOrdenCompra $model){
                
		$model = $model->edit($_GET["nro_orden_compra"]);
		return $model;
	}
	

}