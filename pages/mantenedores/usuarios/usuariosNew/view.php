<?php



namespace UsuariosNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewUsuarios {
	
	public function output(\UsuariosNew\ModelUsuarios $model){

        $data = $model->get();

        

		if(!empty($_POST)){
			$model->execute();
		}
        if(isset($_GET["id"])){
            $data = $model->get()[0];
        }
        
        $ryc = $model->ryc();
        $roles = $ryc[0];
        $cargos = $ryc[1];
        $permisos = $data[2];


		$nombre = false;



        $nombre =false;
        $email =false;
        $rol =false;
        $cargo_id =false;
        $password =false;
        $password2 =false;


		if(sizeof($_GET) && !isset($_GET["id"])){
            if(!isset($_GET["nombre"])){
                $nombre = !$nombre;
            }
            if(!isset($_GET["email"])){
                $email = !$email;
            }
            if(!isset($_GET["rol"])){
                $rol = !$rol;
            }
            if(!isset($_GET["cargo_id"])){
                $cargo_id = !$cargo_id;
            }
            // if(!isset($_GET["password"])){
            //     $password = !$password;
            // }
            // if(!isset($_GET["password2"])){
            //     $password2 = !$password2;
            // }
		}

//print_r(sizeof($_GET));
		ob_start();

		?>


    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/usuarios");?>">Usuarios</a>
        </li>
        <li class="breadcrumb-item active">Mantenedor</li>
    </ol>

    <form method="post" action="<?=base("/usuarios/save");?>" enctype="multipart/form-data" >
    <div class="card">
        <div class="card-body row">
            <input type="hidden" name="id" value="{{ $users->id }}" >
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="<?=isset($_GET["nombre"]) ? $_GET["nombre"]: (isset($data["NOMBRE"]) ? $data["NOMBRE"] : "") ?>">
<!--                 @if ($errors->has('nombre'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('nombre') }}</strong>
                    </span>
                @endif -->


                <?php if ($nombre){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Nombre vacio</strong>
                </span>
                <?php } ?>

            </div>
<!--             <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('apellidos') ? 'has-error' : '' }}">
                <label>Apellidos *</label>
                <input type="text" name="apellidos" class="form-control" value="{{ $users->apellidos ?: old('apellidos') }}"> -->
<!--                 @if ($errors->has('apellidos'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('apellidos') }}</strong>
                    </span>
                @endif
 -->


<!-- 
                <?php if ($nombre){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Nombre vacio</strong>
                </span>
                <?php } ?>
 -->


            <!-- </div> -->
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                <label>E-mail *</label>
                <input type="text" name="email" class="form-control" value="<?=isset($_GET["email"]) ? $_GET["email"]: (isset($data["MAIL"]) ? $data["MAIL"] : "") ?>">
<!--                 @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
 -->
                <?php if ($email){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Email vacio</strong>
                </span>
                <?php } ?>


            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('rol') ? 'has-error' : '' }}">
                <label>Rol *</label>
                <select name="rol" class="selectpicker selectField" placeholder='Seleccione rol' data-live-search='true'>
                    <option value=""></option>
<!--                     @foreach($rolesData as $entityId => $entityValue)
                        @if ($entityValue == substr($users->getRoleNames(),2,strlen($users->getRoleNames())-4))
                            <option selected="true" value="{{ $entityId }}" >{{ $entityValue }}</option>
                        @else
                            <option value="{{ $entityId }}" >{{ $entityValue }}</option>
                        @endif
                    @endforeach

 -->

                    <?php 
                    foreach ($permisos as $rol) { 
                        if (!empty($_GET["rol"]) && $_GET["rol"] == $rol["ID_PERMISO"]){
                            ?>
                            <option selected="true" value="<?= $rol["ID_PERMISO"];?>"><?= $rol["NOMBRE_PERMISO"];?></option>
                            <?php
                        }else{
                            ?>
                            <option value="<?= $rol["ID_PERMISO"];?>"><?= $rol["NOMBRE_PERMISO"];?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
<!--                 @if ($errors->has('rol'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('rol') }}</strong>
                    </span>
                @endif
 -->
                <?php if ($rol){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: rol</strong>
                </span>
                <?php } ?>


            </div>

            <!--***CARGO*** -->
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('cargo_id') ? 'has-error' : '' }}">
                <label>Cargo *</label>

                <select name='cargo_id' class ='selectpicker selectField' placeholder='Seleccione Cargo' data-live-search='true' id ='cargo_id'>
                    <option value="" ></option>





                    <?php 
                    foreach ($cargos as $cargo) { 
                        if (!empty($_GET["cargo_id"]) && $_GET["cargo_id"] == $cargo["ID"]){
                            ?>
                            <option selected="true" value="<?= $cargo["ID"];?>"><?= $cargo["NOMBRE"];?></option>
                            <?php
                        }else{
                            ?>
                            <option value="<?= $cargo["ID"];?>"><?= $cargo["NOMBRE"];?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

<!--                 @if ($errors->has('cargo_id'))
                    <span class="help-block text-danger">
                    <strong>{{ $errors->first('cargo_id') }}</strong>
                    </span>
                @endif
 -->

                <?php if ($cargo_id){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Cargo</strong>
                </span>
                <?php } ?>


            </div>


<!--             <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('password') ? 'has-error' : '' }}">
                <label>Contraseña *</label>
                <input type="password" name="password" class="form-control"> -->
<!--                 @if ($errors->has('password'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
 -->

<!--                 <?php if ($password){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Contraseña</strong>
                </span>
                <?php } ?>

            </div>
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('password') ? 'has-error' : '' }}">
                <label>Confirmar contraseña *</label>
                <input type="password" name="password2" class="form-control"> -->
<!--                 @if ($errors->has('password2'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('password2') }}</strong>
                    </span>
                @endif
 -->



                <!-- <?php if ($password2){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Contraseña</strong>
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
    </script>






		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}