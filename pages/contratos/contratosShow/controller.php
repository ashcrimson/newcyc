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

}