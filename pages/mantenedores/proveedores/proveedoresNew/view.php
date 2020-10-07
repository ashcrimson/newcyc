<?php



namespace ProveedoresNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewProveedores {
	
	public function output(\ProveedoresNew\ModelProveedores $model){

		if(!empty($_POST)){
			$model->execute();
		}
        if(isset($_GET["id"])){
            $data = $model->get()[0];
        }

		$rut = false;
		$razon_social = false;
		$ubicacion = false;


		if(sizeof($_GET) && !isset($_GET["id"])){
			if(!isset($_GET["rut"])){
				$rut = !$rut;
			}
			if(!isset($_GET["razon_social"])){
				$razon_social = !$razon_social;
			}
			if(!isset($_GET["ubicacion"])){
				$ubicacion = !$ubicacion;
			}
		}

//print_r(sizeof($_GET));
		ob_start();

		?>




    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/proveedores/");?>">proveedores</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <form method="post" action="<?=base("/proveedores/save");?>" enctype="multipart/form-data" >
    <div class="card">

        <div class="card-body row">
            <input type="hidden" name="id" value="{{ $proveedor->id }}" >
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('rut') ? 'has-error' : '' }}">
                <label>RUT del proveedor *</label>
                <input type="text" name="rut" class="form-control" value="<?=isset($_GET["rut"]) ? $_GET["rut"]: (isset($data["RUT"]) ? $data["RUT"] : "") ?>">

				<?php if ($rut){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Rut vacio</strong>
				</span>
				<?php } ?>

            </div>

            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('razon_social') ? 'has-error' : '' }}">
                <label>Razón Social del proveedor *</label>
                <input type="text" name="razon_social" class="form-control" value="<?=isset($_GET["razon_social"]) ? $_GET["razon_social"]: (isset($data["NOMBRE"]) ? $data["NOMBRE"] : "") ?>">

				<?php if ($razon_social){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Razon social vacio</strong>
				</span>
				<?php } ?>

            </div>

            <!-- <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('ubicacion') ? 'has-error' : '' }}">
                <label>Ubicación *</label>
                <input type="text" name="ubicacion" class="form-control" value="{{ $proveedor->ubicacion ?: old('ubicacion') }}">

				<?php if ($ubicacion){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Nombre vacio</strong>
				</span>
				<?php } ?> -->

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