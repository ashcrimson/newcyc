<?php

 

namespace ContratosBitacoraShow;

/**
 * controlador de vista
 */
class ControllerContratos {



    public function show(ModelContratos $model){
        return $model;
    }

	//retorna con la paginación
	public function page(ModelContratos $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}

	public function saveBitacora(ModelContratos $model){
	    $model->saveBitacora();
    }

}