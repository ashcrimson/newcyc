<?php



namespace LoginCYC;

/**
 * controlador de vista
 */
class ControllerLoginCYC {
	
	//retorna todos las licitaciones
	public function all(\LoginCYC\ModelLoginCYC $model){
		return $model;
	}

}