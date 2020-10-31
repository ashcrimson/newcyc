<?php



namespace ContratosList;

/**
 * controlador de vista
 */
class ControllerContratos {
	
	//retorna todos las licitaciones
	public function all(\ContratosList\ModelContratos $model){
		return $model;
	}

	//retorna solo la licitacion solicitada
	public function filter(\ContratosList\ModelContratos $model){
		if(isset($_GET["nro_licitacion"])){
			$model = $model->getId($_GET["nro_licitacion"]);
		}
		return $model;
	}


	//retorna con la paginación 
	public function page(\ContratosList\ModelContratos $model){
		if(isset($_GET["page"]) && $_GET["page"] >=1 ){
			$model = $model->getPage($_GET["page"]);
		}
		return $model;
	}


	public function delete(\ContratosList\ModelContratos $model){
		if(isset($_GET["nro_licitacion"])){
			$model = $model->delete($_GET["nro_licitacion"]);
		}
		return $model;
	}

    public function saveBitacora(\ContratosList\ModelContratos $model){

	    $model = $model->saveBitacora();
        return $model;
    }

}