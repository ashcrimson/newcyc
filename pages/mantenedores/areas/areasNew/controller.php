<?php



namespace AreasNew;

/**
 * controlador de vista
 */
class ControllerAreas {
	
	//hace nada c:
	public function all(\AreasNew\ModelAreas $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\AreasNew\ModelAreas $model){
		$model->new();
		return $model;
	}

	//solicita edicion de registro
	public function edit(\AreasNew\ModelAreas $model){
		if(isset($_GET["id"]) && $_GET["id"] >=1 ){
			$model = $model->edit($_GET["id"]);
		}
		return $model;
	}

}