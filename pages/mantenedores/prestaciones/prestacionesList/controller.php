<?php
   
 

namespace PrestacionesList;

/**
 * controlador de vista
 */
class ControllerPrestaciones {
	
	//retorna todos las licitaciones
	public function all(\PrestacionesList\ModelPrestaciones $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\PrestacionesList\ModelPrestaciones $model){
		if(isset($_GET["id"])){
			$model = $model->getId($_GET["id"]);
		}
		
		return $model;
	}


	//retorna con la paginación 
	public function page(\PrestacionesList\ModelPrestaciones $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}



	public function delete(\PrestacionesList\ModelPrestaciones $model){
		if(isset($_GET["id"])){
			$model = $model->delete($_GET["id"]);
		}
		return $model;
	}
}