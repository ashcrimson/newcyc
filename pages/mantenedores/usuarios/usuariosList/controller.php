<?php



namespace UsuariosList;

/**
 * controlador de vista
 */
class ControllerUsuarios {
	
	//retorna todos las licitaciones
	public function all(\UsuariosList\ModelUsuarios $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\UsuariosList\ModelUsuarios $model){
		if(isset($_GET["tipo"])){
			$model = $model->getId($_GET["tipo"]);
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
		if(isset($_GET["tipo"])){
			$model = $model->delete($_GET["tipo"]);
		}
		return $model;
	}
}