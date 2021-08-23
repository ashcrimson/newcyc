<?php



namespace AreasNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewAreas {
	
	public function output(\AreasNew\ModelAreas $model){
		if(!empty($_POST)){
			$model->execute();
		}
        if(isset($_GET["id"])){
            $data = $model->get()[0];
        }

		$cargos = $model->getDataListBox()['cargos'];


		if(sizeof($_GET) && !isset($_GET["id"])){
			if(!isset($_GET["area"])){
				$area = !$area;
			}
		}

//print_r(sizeof($_GET));
		ob_start();

		?>


    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/areas");?>" class="encabezado">Areas</a>
        </li>
        
    </ol>

    <form method="post" action="<?=base("/areas/save");?>" enctype="multipart/form-data" >
    <div class="card">

        <div class="card-body row">
            <input type="hidden" name="id" value="<?= $_GET["id"] ?? "" ?>" >
            <div class="form-group col-xs-4 col-md-4 col-lg-4 ">
                <label>Nombre del area *</label>
                <input type="text" name="area" class="form-control" value="<?=isset($_GET["area"]) ? $_GET["area"]: (isset($data["AREA"]) ? $data["AREA"] : "") ?>">

            </div>

            <div class="form-group col-xs-4 col-md-4 col-lg-4 ">
                <label>Cargos</label>
                <div>
                    <select name="id_cargo" class="selectpicker selectField" placeholder='Seleccione cargo' data-live-search='true'>
                        <option value=""></option>
                        <?php
                        foreach ($cargos as $cargo){
                            $select =  ($data["ID_CARGO"] == $cargo["ID_CARGO"]) ? "selected" : '';
                            ?>
                            <option value="<?=$cargo["ID_CARGO"];?>" <?=$select;?>>
                                <?=$cargo["NOMBRE"];?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-footer">
        <div class="row">
            <div class="col-sm-8">
            <button type="submit" class="btn-primary btn rounded" ><i class="icon-floppy-disk"></i> Guardar</button>
            </div>
        </div>
        </div>

    </div>
  </form>


        <script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
        <script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
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
        </script>



		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}