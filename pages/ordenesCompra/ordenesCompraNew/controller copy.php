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

}