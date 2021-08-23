<?php



namespace NotFound;

/**
 * pagina 404, controlador vacio, unica funcion retorna modelo sin cambios
 */
class ControllerNotFound {
	
	//retorna todos las licitaciones
	public function all(\NotFound\ModelNotFound $model){
		return $model;
	}

}