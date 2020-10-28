<?php



namespace MonedasList;

/**
 * controlador de vista
 */
class ControllerMonedas {
	
	//retorna todos las licitaciones
	public function all(\MonedasList\ModelMonedas $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\MonedasList\ModelMonedas $model){
		if(isset($_GET["tipo"])){
			$model = $model->getId($_GET["tipo"]);
		}
		return $model;
	}


	//retorna con la paginación 
	public function page(\MonedasList\ModelMonedas $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\MonedasList\ModelMonedas $model){
		if(isset($_GET["id"])){
			$model = $model->delete($_GET["id"]);
		}
		return $model;
	}
}