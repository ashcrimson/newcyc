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
            
            if(!isset($_GET["nombre_fantasia"])){
				$nombre_fantasia = !$nombre_fantasia;
            }
            
            if(!isset($_GET["telefono"])){
				$telefono = !$telefono;
            }
            
            if(!isset($_GET["email"])){
				$email = !$email;
            }
            
            if(!isset($_GET["direccion"])){
				$direccion = !$direccion;
            }
            
            if(!isset($_GET["comuna"])){
				$comuna = !$comuna;
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
                <label>Razón Social *</label>
                <input type="text" name="nombre" class="form-control" value="<?=isset($_GET["nombre"]) ? $_GET["nombre"]: '' ?>">
				<?php if ($nombre){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Nombre vacio</strong>
				</span>
				<?php } ?>
            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nombre_fantasia') ? 'has-error' : '' }}">
                <label>Nombre Fantasía*</label>
                <input type="text" name="nombre_fantasia" class="form-control" value="<?=isset($_GET["nombre_fantasia"]) ? $_GET["nombre_fantasia"]: '' ?>">
				<?php if ($nombre_fantasia){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Nombre Fantasía vacío</strong>
				</span>
				<?php } ?>
            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('telefono') ? 'has-error' : '' }}">
                <label>Teléfono*</label>
                <input type="text" name="telefono" class="form-control" value="<?=isset($_GET["telefono"]) ? $_GET["telefono"]: '' ?>">
				<?php if ($telefono){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Teléfono vacío</strong>
				</span>
				<?php } ?>
            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>E-mail*</label>
                <input type="text" name="email" class="form-control" value="<?=isset($_GET["email"]) ? $_GET["email"]: '' ?>">
				<?php if ($email){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: E-mail vacío</strong>
				</span>
				<?php } ?>
            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('direccion') ? 'has-error' : '' }}">
                <label>Dirección*</label>
                <input type="text" name="direccion" class="form-control" value="<?=isset($_GET["direccion"]) ? $_GET["direccion"]: '' ?>">
				<?php if ($email){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Dirección vacía</strong>
				</span>
				<?php } ?>
            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('comuna') ? 'has-error' : '' }}">
                <label>Comuna*</label>
                <input type="text" name="comuna" class="form-control" value="<?=isset($_GET["comuna"]) ? $_GET["comuna"]: '' ?>">
				<?php if ($email){ ?>
				<span class="help-block text-danger"> 
					<strong>Error: Comuna vacía</strong>
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