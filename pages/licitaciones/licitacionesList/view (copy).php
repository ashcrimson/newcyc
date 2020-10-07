<?php



namespace LicitacionesList;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewLicitacionesCopy {
	
	public function output(\LicitacionesList\ModelLicitaciones $model){

		$listaLicitaciones = $model->get()[0];
		$numerosLicitaciones = $model->get()[1];

		//salida a mostrar
		$output = "";
		//picker con todos los numeros de licitacion
		$picker = "";
		//licitaciones filtradas
		$licitaciones = "";


		//genera boton limpieza de filtros
		if(!empty($_GET)){
			$btnEmpty = "<a class=\"btn btn-default\" href=\"./licitaciones\">Limpiar Filtros</a>";
		}else{
			$btnEmpty = "";
		}

		foreach ($numerosLicitaciones as $licitacion) {
			if (isset($_GET["nro_licitacion"]) && $_GET["nro_licitacion"]  == $licitacion["NRO_LICITACION"] ){
				$selected = "selected='true'";
			}else{
				$selected = "";
			}
			$picker .= "<option $selected value=\"" . $licitacion["NRO_LICITACION"] . "\">" . $licitacion["NRO_LICITACION"] . "</option>\n";
		}

		foreach ($listaLicitaciones as $licitacion) {
			$licitaciones .=  "<tr><td>" . $licitacion["NRO_LICITACION"] . "</td>";
			$licitaciones .=  "<td>" . $licitacion["PRESUPUESTO"] . "</td>";
			$licitaciones .=  "<td>" . $licitacion["DETALLE"] . "</td>";
			if ($licitacion["NRO_DOCUMENTO"] ==  null && empty($licitacion["NRO_DOCUMENTO"])){
				$licitaciones .= "<td> N/A </td></tr>";
			}else{
				$licitaciones .= "<td><a target=\"_blank\" href=\"./licitaciones\">Visualizar</a> </td></tr>";
			}
		}

$output = "

    <script lang=\"javascript\" src=\"/assets/frontend/js/xlsx.full.min.js\"></script>
    <script lang=\"javascript\" src=\"/assets/frontend/js/FileSaver.js\"></script>
    <script lang=\"javascript\" src=\"/assets/frontend/js/xlsx.core.min.js\"></script>

       
    <ol class=\"breadcrumb\">
        <li class=\"breadcrumb-item\">
            <a href=\"./licitaciones\">Licitaciones</a>
        </li>        
    </ol>

    <!-- DataTables Example -->
    <div class=\"card mb-3\">
        <div class=\"card-header\">
            <form method=\"get\" class=\"form-horizontal\" action=\"./licitaciones\">
                <!-- {!! csrf_field() !!}  -->
                
                <div class=\"row\"> 
                    <div class=\"col-3\">
                        <label>ID Licitacion</label>
                        <div>
                            <select name=\"nro_licitacion\" class=\"selectpicker selectField\" placeholder=\"Seleccione ID Licitación\" data-live-search='true'>
                                <option value=\"\"></option>
                                $picker
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                

                <div class=\"btn-group float-right\">
						$btnEmpty
                        <button type=\"submit\" class=\"btn btn-primary rounded\"><i class=\"fa fa-search\"></i> Buscar</button>
                </div>

                <div>
                    <i class=\"fas fa-table\"> Registros</i>
                </div>

                <div class=\"card-body\">
                    <!-- @if (session('status'))
                    <div class=\"alert alert-success\" role=\"alert\">
                        {{ session('status')}}
                    </div>
                    @endif   -->
       
                </div>
            </form>
        </div>
        
        <div class=\"card-body\">
            <!-- @if (session('status'))
                <div class=\"alert alert-success\" role=\"alert\">
                    {{ session('status')}}
                </div>
                
            @endif -->
            <div class=\"table-responsive table-sm -md -lg -x\">
                <table class=\"table table-bordered\"  class=\"table-sm w-25\" id=\"dataLicitaciones\" width=100% cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>ID Licitación</th>
                            <th>Presupuesto</th>
                            <th>Descripción</th>
                            <th>Adjunto</th>
                            <!-- {{-- <th>Acción</th> --}} -->
                        </tr>
                    </thead>
                        <tbody>
                        	$licitaciones
                        </tbody>
                </table>
            </div>
            
            
        </div>

        
        <div class=\"card-footer\">
                
        </div>
    </div>

    

    


    <script src=\"./assets/assets/frontend/js/jquery-3.3.1.js\"></script>
    <script src=\"./assets/assets/frontend/js/selectize.js\"></script>
    <script>
        $('.selectField').selectize({
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            dropdownParent: 'body'
        });

        $('.selectMulti').selectize({
            maxItems: 3
        });
	</script>";


		//return $output;
		return "";
	}
}