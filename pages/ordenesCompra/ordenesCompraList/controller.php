<?php

 

namespace OrdenCompraList;

/**
 * controlador de vista
 */
class ControllerOrdenCompra {
	
	//retorna todos las licitaciones
	public function all(\OrdenCompraList\ModelOrdenCompra $model){
		return $model;
	}
 
	//retorna solo la licitacion solicitada
	public function filter(\OrdenCompraList\ModelOrdenCompra $model){
		if(isset($_GET["nro_orden_compra"])){
			$model = $model->getId($_GET["nro_orden_compra"]);
		}
		return $model;
	}
 

	//retorna con la paginación 
	public function page(\OrdenCompraList\ModelOrdenCompra $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\OrdenCompraList\ModelOrdenCompra $model){
		if(isset($_GET["nro_orden_compra"])){
			$model = $model->delete($_GET["nro_orden_compra"]);
		}
		return $model;
	}
}