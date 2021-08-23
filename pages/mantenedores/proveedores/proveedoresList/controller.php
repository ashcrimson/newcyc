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
		if(isset($_GET["id"])){
			$model = $model->getId($_GET["id"]);
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
		if(isset($_GET["id"])){
			$model = $model->delete($_GET["id"]);
		}
		return $model;
	}
}