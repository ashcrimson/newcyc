<?php



namespace ProveedoresNew;

/** 
 * controlador de vista
 */
class ControllerProveedores {
	
	//hace nada c:
	public function all(\ProveedoresNew\ModelProveedores $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\ProveedoresNew\ModelProveedores $model){
		$model->new();
		return $model;
	}
	//solicita la edicionde nuevo registro
	public function edit(\ProveedoresNew\ModelProveedores $model){
		if(isset($_GET["id"]) && $_GET["id"] != "" ){
			$model = $model->edit($_GET["id"]);
		}
		return $model;
	}

}