<?php



namespace LogoutCYC;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewLogoutCYC {
	
	public function output(\LogoutCYC\ModelLogoutCYC $model){
	// public function output(array $arr){

		ob_start();
		$model->get();

		?>

		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
		
	}
}