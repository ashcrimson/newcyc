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
        
        
        $cargos = $data[0];
        $permisos = $data[1];


		$nombre = false;



        $nombre =false;
        $email =false;
        $rol =false;
        $cargo_id =false;
        $password =false;
        


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
            
		}

//print_r(sizeof($_GET));
		ob_start();

		?>


    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?=base("/usuarios");?>" class="encabezado">Usuarios</a>
        </li>
      
    </ol>

    <form method="post" action="<?=base("/usuarios/save");?>" enctype="multipart/form-data" >
    <div class="card">
        <div class="card-body row">
            <input type="hidden" name="id" value="<?= $_GET["id"] ?? "" ?>" >
            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="<?=isset($_GET["nombre"]) ? $_GET["nombre"]: (isset($data["NOMBRE"]) ? $data["NOMBRE"] : "") ?>">


                <?php if ($nombre){ ?>
                <span class="help-block text-danger"> 
                    <strong>Error: Nombre vacio</strong>
                </span>
                <?php } ?>

            </div>


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
                <input type="text" name="email" class="form-control" value="<?=isset($_GET['email']) ? $_GET['email']: (isset($data['MAIL']) ? $data['MAIL'] : '') ?>" required>
<!--                 @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
 -->
            </div>

            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('anexo') ? 'has-error' : '' }}">
                <label>Anexo</label>
                <input type="text" name="anexo" class="form-control" value="<?=isset($_GET['anexo']) ? $_GET['anexo']: (isset($data['ANEXO']) ? $data['ANEXO'] : '') ?>" required>
<!--                 @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
 -->
            </div>
            

                <?php feedback();?>
                
                    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$selectContrato ? 'has-error' : '' ;?>">
                        <label>Rol</label>
                        <input type="hidden" name="submit" value="true">
                        <select class="selectpicker " placeholder='Seleccione Rol' name="rol" id="selectContrato" value="<?=isset($_GET["selectContrato"]) ? $_GET["selectContrato"]: (isset($registroEdit["TIPO"]) ? $registroEdit["TIPO"] : "") ?>">
                        <option value=""></option>

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
                    
                        
                    </div>
               
			
                    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$licitacion ? 'has-error' : '' ;?>" id="licitacion"  >
                        <label>Cargo</label>
                        <select name='cargo_id' class ='selectpicker selectField' placeholder='Seleccione Cargo' data-live-search='true' id ='licitacion_id' value="<?=isset($_GET["licitacion"]) ? $_GET["licitacion"]: (isset($registroEdit["NRO_LICITACION"]) ? $registroEdit["NRO_LICITACION"] : "") ?>">
                            <option value="" ></option>


                            <?php 
                            foreach ($cargos as $cargo) { 
                                if (!empty($_GET["cargo_id"]) && $_GET["cargo_id"] == $cargo["ID_CARGO"]){
                                    ?>
                                    <option selected="true" value="<?= $cargo["ID_CARGO"];?>"><?= $cargo["NOMBRE"];?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?= $cargo["ID_CARGO"];?>"><?= $cargo["NOMBRE"];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        
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

        $('#selectContrato').selectize({

        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        dropdownParent: 'body',
        onChange: function(value) {
            if(value != "2"){
                $('#licitacion').hide(); 
            } else {
                $('#licitacion').show(); 
            }
            // console.log("Cambio", value);
        }
        });
    </script>

 




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}