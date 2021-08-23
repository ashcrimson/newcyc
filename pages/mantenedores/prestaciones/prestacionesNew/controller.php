<?php



namespace PrestacionesNew;

/** 
 * controlador de vista
 */
class ControllerPrestaciones {
	
	//hace nada c:
	public function all(\PrestacionesNew\ModelPrestaciones $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\PrestacionesNew\ModelPrestaciones $model){
		$model->new();
		return $model;
	}
	//solicita la edicionde nuevo registro
	public function edit(\PrestacionesNew\ModelPrestaciones $model){
		if(isset($_GET["id"]) && $_GET["id"] != "" ){
			$model = $model->edit($_GET["id"]);
		}
		return $model;
	}

}