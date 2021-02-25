<?php



namespace UsuariosNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewUsuarios {
	
	public function output(\UsuariosNew\ModelUsuarios $model){


        //si se envia el formulario
		if(!empty($_POST)){
			$model->execute();
		}

		//si se esta editando un registro
        if(isset($_GET["id"])){
            $registroEdit = $model->get();
        }
        


        $dataListBox = $model->getDataListBox();
        $cargos = $dataListBox['cargos'];
        $permisos = $dataListBox['permisos'];



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
                <input type="text" name="nombre" class="form-control"
                       value="<?=$_GET["nombre"] ?? $registroEdit["NOMBRE"] ?? "" ?>">


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
                <input type="text" name="email" class="form-control"

                       value="<?=$_GET["email"] ?? $registroEdit["MAIL"] ?? "" ?>" required>
<!--                 @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
 -->
            </div>

            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 {{ $errors->has('anexo') ? 'has-error' : '' }}">
                <label>Anexo</label>
                <input type="text" name="anexo" class="form-control"
                       value="<?=$_GET["anexo"] ?? $registroEdit["ANEXO"] ?? "" ?>" required>
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
                                $selected = $registroEdit['ID_PERMISO']==$rol["ID_PERMISO"] ? "selected" : "";
                                ?>
                                <option value="<?= $rol["ID_PERMISO"];?>" <?=$selected?>><?= $rol["NOMBRE_PERMISO"];?></option>
                                <?php
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
                                $selected = $registroEdit['ID_CARGO']==$cargo["ID_CARGO"] ? "selected" : "";
                                ?>
                                <option value="<?= $cargo["ID_CARGO"];?>" <?=$selected?>><?= $cargo["NOMBRE"];?></option>
                                <?php
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
                <input type="hidden" name="id" value="<?=$registroEdit['ID_USUARIO'] ?? '' ?>" >
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