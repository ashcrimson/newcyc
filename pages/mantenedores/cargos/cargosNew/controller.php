<?php



namespace CargosNew;

/**
 * controlador de vista
 */
class ControllerCargos {
	
	//hace nada c:
	public function all(\CargosNew\ModelCargos $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\CargosNew\ModelCargos $model){
		$model->new();
		return $model;
	}

	//solicita edicion de registro
	public function edit(\CargosNew\ModelCargos $model){
		if(isset($_GET["id"]) && $_GET["id"] >=1 ){
			$model = $model->edit($_GET["id"]);
		}
		return $model;
	}

}