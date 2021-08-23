<?php



namespace CargosNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewCargos {
	
	public function output(\CargosNew\ModelCargos $model){
		if(!empty($_POST)){
			$model->execute();
		}
        if(isset($_GET["id"])){
            $data = $model->get()[0];
        }

		$nombre = false;


		if(sizeof($_GET) && !isset($_GET["id"])){
			if(!isset($_GET["nombre"])){
				$nombre = !$nombre;
			}
		}

//print_r(sizeof($_GET));
		ob_start();

		?>


    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/cargos");?>" class="encabezado">Cargos</a>
        </li>
        
    </ol>

    <form method="post" action="<?=base("/cargos/save");?>" enctype="multipart/form-data" >
    <div class="card">

        <div class="card-body row">
            <input type="hidden" name="id" value="<?= $_GET["id"] ?? "" ?>" >
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                <label>Nombre del cargo *</label>
                <input type="text" name="nombre" class="form-control" value="<?=isset($_GET["nombre"]) ? $_GET["nombre"]: (isset($data["NOMBRE"]) ? $data["NOMBRE"] : "") ?>">

				<?php if ($nombre){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Nombre vacio</strong>
				</span>
				<?php } ?>
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






		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}