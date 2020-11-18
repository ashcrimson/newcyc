<?php

 
 
namespace ContratosList;
 
/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class Detalles {
    public function output(\ContratosList\ModelContratos $model){

        $data = $model->get();

        $listado = $data[0];
        $totales = $data[1];

        //Los select
        $proveedores = $data[2];
        $cargos = $data[3];
        $licitaciones = $data[4];

        $listado2 = $data[5];

        ob_start();

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";
        
    }
}
?>


