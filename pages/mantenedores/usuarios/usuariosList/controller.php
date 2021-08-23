<?php



namespace UsuariosList;

/**
 * controlador de vista
 */
class ControllerUsuarios {
	
	//retorna todos los usuarios
	public function all(\UsuariosList\ModelUsuarios $model){
		return $model;
	}

	//retorna solo el usuario solicitado
	public function filter(\UsuariosList\ModelUsuarios $model){
		if(isset($_GET["id"])){
			$model = $model->getId($_GET["id"]);
		}
		return $model;
	}

 
	//retorna con la paginación 
	public function page(\UsuariosList\ModelUsuarios $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\UsuariosList\ModelUsuarios $model){
		if(isset($_GET["id"])){
			$model = $model->delete($_GET["id"]);
		}
		return $model;
	}
}