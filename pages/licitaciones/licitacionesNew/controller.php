<?php



namespace LicitacionesNew;

/**
 * controlador de vista
 */
class ControllerLicitaciones {
	
	//hace nada c:
	public function all(\LicitacionesNew\ModelLicitaciones $model){
		return $model;
	}

	//solicita la creacion de nuevo registro
	public function new(\LicitacionesNew\ModelLicitaciones $model){
		$model->new();
		return $model;
	}

    public function edit(\LicitacionesNew\ModelLicitaciones $model){
        return $model;
    }
}