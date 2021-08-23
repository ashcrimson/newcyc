<?php



namespace MonedasNew;

/**
 * controlador de vista
 */
class ControllerMonedas {
	
	//hace nada c:
	public function all(\MonedasNew\ModelMonedas $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\MonedasNew\ModelMonedas $model){
		$model->new();
		return $model;
	}

	//solicita la edicicon de registro
	public function edit(\MonedasNew\ModelMonedas $model){
		if(isset($_GET["id"]) && $_GET["id"] != "" ){
			$model = $model->edit($_GET["id"]);
		}
		return $model;
	}

}