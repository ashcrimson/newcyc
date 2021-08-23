<?php



namespace UsuariosNew;

/**
 * controlador de vista
 */
class ControllerUsuarios {
	
	//hace nada c:
	public function all(\UsuariosNew\ModelUsuarios $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\UsuariosNew\ModelUsuarios $model){
		$model->new();
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function edit(\UsuariosNew\ModelUsuarios $model){
		if(isset($_GET["id"]) && $_GET["id"] != "" ){
			$model = $model->edit($_GET["id"]);
		}
		return $model;
	}

}