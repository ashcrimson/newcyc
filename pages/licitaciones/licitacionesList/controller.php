<?php



namespace LicitacionesList;

/**
 * controlador de vista
 */
class ControllerLicitaciones {
	
	//retorna todos las licitaciones
	public function all(\LicitacionesList\ModelLicitaciones $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\LicitacionesList\ModelLicitaciones $model){
		if(isset($_GET["nro_licitacion"])){
			$model = $model->getId($_GET["nro_licitacion"]);
		}
		return $model;
	}


	//retorna con la paginación 
	public function page(\LicitacionesList\ModelLicitaciones $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\LicitacionesList\ModelLicitaciones $model){
		if(isset($_GET["nro_licitacion"])){
			$model = $model->delete($_GET["nro_licitacion"]);
		}
		return $model;
	}
}