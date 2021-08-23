<?php



namespace Home;

/**
 * pagina 404, vista solo retorna mensaje de 404
 */
class ViewHome {
	
	public function output(\Home\ModelHome $model){
        session_start(); 
		ob_start();

		?>

		    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="./" class="encabezado">Home</a>
        </li>
        <li class="breadcrumb-item active">Vista</li>
    </ol>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Inicio</div>
                        <div class="card-body">
                            <!-- @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif -->
                            <p>
                                Bienvenido <?php echo $_SESSION["nombre"]; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
		
		
	}
}