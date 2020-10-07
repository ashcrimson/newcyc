<?php



namespace ContratosNew;

/**
 * controlador de vista
 */
class ControllerContratos {
	
	//hace nada c:
	public function all(\ContratosNew\ModelContratos $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\ContratosNew\ModelContratos $model){
		$model->new();
		return $model;
	}

}