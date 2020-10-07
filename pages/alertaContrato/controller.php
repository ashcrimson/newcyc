<?php



namespace AlertaContrato;

/**
 * pagina 404, controlador vacio, unica funcion retorna modelo sin cambios
 */
class ControllerAlertaContrato {
	
	//retorna todos las licitaciones
	public function all(\AlertaContrato\ModelAlertaContrato $model){
		return $model;
	}

}