<?php



namespace AreasList;
 
/**
 * controlador de vista
 */
class ControllerAreas {
	
	//retorna todos las areas
	public function all(\AreasList\ModelAreas $model){
		return $model;
	}

	//retorna solo la area solicitada
	public function filter(\AreasList\ModelAreas $model){
		if(isset($_GET["tipo"])){
			$model = $model->getId($_GET["tipo"]);
		}
		return $model;
	}


	//retorna con la paginación 
	public function page(\AreasList\ModelAreas $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\AreasList\ModelAreas $model){
		if(isset($_GET["id"])){
			$model = $model->delete($_GET["id"]);
		}
		return $model;
	}
}