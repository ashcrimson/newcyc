<?php



namespace CargosList;

/**
 * controlador de vista
 */
class ControllerCargos {
	
	//retorna todos las licitaciones
	public function all(\CargosList\ModelCargos $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\CargosList\ModelCargos $model){
		if(isset($_GET["tipo"])){
			$model = $model->getId($_GET["tipo"]);
		}
		return $model;
	}


	//retorna con la paginación 
	public function page(\CargosList\ModelCargos $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\CargosList\ModelCargos $model){
		if(isset($_GET["id"])){
			$model = $model->delete($_GET["id"]);
		}
		return $model;
	}
}