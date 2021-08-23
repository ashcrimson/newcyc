<?php



namespace NotFound;

/**
 * pagina 404, vista solo retorna mensaje de 404
 */
class ViewNotFound {
	
	public function output(\NotFound\ModelNotFound $model){
		
		$output = "Error, pagina no encontrada.";
		
		return $output;
		
	}
}