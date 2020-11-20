<?php

   
 
namespace ProveedoresShow;

/**
 * controlador de vista
 */
class ControllerProveedores {
	
	public function show(ModelProveedores $model){
		$model = $model->show($_GET["id"]);
		return $model;
	}

}