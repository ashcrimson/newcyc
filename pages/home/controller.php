<?php



namespace Home;

/**
 * pagina 404, controlador vacio, unica funcion retorna modelo sin cambios
 */
class ControllerHome {
	
	//retorna todos las licitaciones
	public function all(\Home\ModelHome $model){
		return $model;
	}

}