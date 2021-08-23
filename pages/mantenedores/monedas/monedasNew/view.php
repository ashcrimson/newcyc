<?php



namespace MonedasNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewMonedas {
	
	public function output(\MonedasNew\ModelMonedas $model){

		if(!empty($_POST)){
			$model->execute();
		}
        if(isset($_GET["id"])){
            $data = $model->get()[0];
        }

		$codigo = false;
		$nombre = false;
		$factor_conversion = false;


        if(sizeof($_GET) && !isset($_GET["id"])){
			if(!isset($_GET["codigo"])){
				$codigo = !$codigo;
			}
			if(!isset($_GET["nombre"])){
				$nombre = !$nombre;
			}
			if(!isset($_GET["factor_conversion"])){
				$factor_conversion = !$factor_conversion;
			}
		}

//print_r(sizeof($_GET));
		ob_start();

		?>




    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/monedas/");?>" class="encabezado">Monedas</a>
        </li>
        
    </ol>
    
    <form method="post" action="<?=base("/monedas/new");?>" enctype="multipart/form-data" >
    <!-- {!! csrf_field() !!} -->
    <div class="card">

        <div class="card-body row">
            <div class="row col-12">
                <input type="hidden" name="id" value="<?=isset($_GET["id"]) ? $_GET["id"]: "" ?>" >
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 offset-pd-4 {{ $errors->has('codigo') ? 'has-error' : '' }}">
                    <label>Código de la moneda *</label>
                    <input type="text" name="codigo" class="form-control" value="<?=isset($_GET["codigo"]) ? $_GET["codigo"]: (isset($data["CODIGO"]) ? $data["CODIGO"] : "") ?>">
                    <!-- @if ($errors->has('codigo'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('codigo') }}</strong>
                        </span>
                    @endif -->
					<?php if ($codigo){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: codigo</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                    <label>Nombre de la moneda *</label>
                    <input type="text" name="nombre" class="form-control" value="<?=isset($_GET["nombre"]) ? $_GET["nombre"]: (isset($data["NOMBRE"]) ? $data["NOMBRE"] : "") ?>">
                    <!-- @if ($errors->has('nombre'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif -->
					<?php if ($nombre){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: nombre</strong>
					</span>
					<?php } ?>
                </div>
            </div>

            <div class="row col-12">
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('factor_conversion') ? 'has-error' : '' }}">
                    <label>Factor conversión de la moneda *</label>
                    <input type="text" name="factor_conversion" class="form-control" value="<?=isset($_GET["factor_conversion"]) ? $_GET["factor_conversion"]: (isset($data["EQUIVALENCIA"]) ? $data["EQUIVALENCIA"] : "") ?>">
                    <!-- @if ($errors->has('factor_conversion'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('factor_conversion') }}</strong>
                        </span>
                    @endif -->
					<?php if ($factor_conversion){ ?>
					<span class="help-block text-danger"> 
						<strong>Error: factor conversion</strong>
					</span>
					<?php } ?>
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







		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}