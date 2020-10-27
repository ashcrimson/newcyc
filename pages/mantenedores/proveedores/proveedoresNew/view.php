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
        
        $rut = false;
        $nombre = false;



		if(sizeof($_GET)){
			if(!isset($_GET["rut"])){
				$rut = !$rut;
			}
			if(!isset($_GET["nombre"])){
				$nombre = !$nombre;
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
                <input type="hidden" name="submit" value="true">
                <input type="text" name="rut" class="form-control" value="<?=isset($_GET["rut"]) ? $_GET["rut"]: '' ?>">

				<?php if ($rut){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Rut vacio</strong>
				</span>
				<?php } ?>
            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="<?=isset($_GET["nombre"]) ? $_GET["nombre"]: '' ?>">
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
            <button type="submit" name="submit" class="btn-primary btn rounded" ><i class="icon-floppy-disk"></i> Guardar</button>
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