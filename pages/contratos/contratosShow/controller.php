<?php

 

namespace ContratosShow;

/**
 * controlador de vista
 */
class ControllerContratos {

    //retorna todos las licitaciones
    public function all(ModelContratos $model){
        return $model;
	}
	
	//retorna solo la licitacion solicitada
	public function filter(ModelContratos $model){
	    if(isset($_GET["id_contrato"])){
			$model = $model->getId($_GET["id_contrato"]);
		}
		return $model;
	}

	public function show(ModelContratos $model){
		$model = $model->show($_GET["id"]);
		return $model;
	}

	//retorna con la paginación 
	public function page(ModelContratos $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}

}