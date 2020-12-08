<?php



namespace ContratosShow;

/**
 * controlador de vista
 */
class ControllerContratos {

	public function show(ModelContratos $model){
		$model = $model->show($_GET["id"]);
		return $model;
	}

	//retorna con la paginación 
	public function page(ModelContratos $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}

}