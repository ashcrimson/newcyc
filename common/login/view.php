<?php



namespace LoginCYC;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewLoginCYC {
	
	public function output(\LoginCYC\ModelLoginCYC $model){
	// public function output(array $arr){

		ob_start();

		$model->get();
		
		?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="HEtPAanT2kiMJ4hRFdUhQI5RmVz0fqLRBw7OBKXk">

        <title>Contratos&amp;Convenios</title>

        <!-- Scripts -->
        <script src="<?=base();?>/assets/js/app.js" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="<?=base();?>/assets/css/app.css" rel="stylesheet">

        <!-- Core plugin JavaScript-->
        <script src="<?=base();?>/assets/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

        <link href="<?=base();?>/assets/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Plantilla -->
        <!-- Custom fonts for this template-->
        <link href="<?=base();?>/assets/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="<?=base();?>/assets/assets/frontend/css/sb-admin.css" rel="stylesheet">
    </head>

    <body class="bg-dark">


    <div class="container">

        <div class="card card-login mx-auto mt-5">

            <?=feedback2()?>

            <div class="card-header">Acceder</div>
            
            <div class="card-body">
                <form method="POST" action="<?=base("/login");?>">

                    <div class="form-group">
                        <div class="form-label-group">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" name="email" required="required" autofocus="autofocus">
                        <!-- <input id="inputEmail" type="email" class="form-control" placeholder="Email address" required="required" autofocus="autofocus"> -->
                            <label for="email">Correo Electrónico</label>
                        <!-- <label for="inputEmail">Email address</label> -->
                            
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required="required">
                            <!-- <input id="inputPassword" type="password" class="form-control" placeholder="Password" required="required"> -->
                            <label for="password">Contraseña</label>
                            <!-- <label for="inputPassword">Password</label> -->
                            
                        </div>
                    </div>

                    <!--
                        <div class="form-group">
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me">
                            Remember Password
                        </label>
                        </div>
                    </div> 
                    -->

                    <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Acceder
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



        <!-- Bootstrap core JavaScript-->
        <script src="<?=base();?>/assets/assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?=base();?>/assets/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base();?>/assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?=base();?>/assets/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    </body>
</html>


		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
		
	}
}