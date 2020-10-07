<?php



namespace ProveedoresList;

/**
 * controlador de vista
 */
class ControllerProveedores {
	
	//retorna todos las licitaciones
	public function all(\ProveedoresList\ModelProveedores $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\ProveedoresList\ModelProveedores $model){
		if(isset($_GET["rut"]) && !empty($_GET["rut"])){
			$model = $model->getId($_GET["rut"]);
		}
		if(isset($_GET["razon_social"]) && !empty($_GET["razon_social"])){
			$model = $model->getId($_GET["razon_social"]);
		}
		return $model;
	}


	//retorna con la paginación 
	public function page(\ProveedoresList\ModelProveedores $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\ProveedoresList\ModelProveedores $model){
		if(isset($_GET["nro_licitacion"])){
			$model = $model->delete($_GET["nro_licitacion"]);
		}
		return $model;
	}
}