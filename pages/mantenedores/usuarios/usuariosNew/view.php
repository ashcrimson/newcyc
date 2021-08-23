<?php



namespace UsuariosNew;

/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewUsuarios {
	
	public function output(\UsuariosNew\ModelUsuarios $model){


        $authUser = authUser($model->pdo);

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
        $areas = $dataListBox['areas'];


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
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" class="form-control"
                           value="<?=$_GET["nombre"] ?? $registroEdit["NOMBRE"] ?? "" ?>">
                </div>


                <!-- </div> -->
                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 ">
                    <label>E-mail *</label>
                    <input type="text" name="email" class="form-control"
                           value="<?=$_GET["email"] ?? $registroEdit["MAIL"] ?? "" ?>" required>
                </div>

                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 ">
                    <label>Anexo</label>
                    <input type="text" name="anexo" class="form-control"
                           value="<?=$_GET["anexo"] ?? $registroEdit["ANEXO"] ?? "" ?>" required>
                </div>

                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                    <label>Rol</label>
                    <select class="selectpicker " placeholder='Seleccione Rol' name="rol" id="selectRol">
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

                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4"  id="divCargo"  >
                    <label>Cargo</label>
                    <select name='cargo_id' class='selectpicker selectField' placeholder='Seleccione Cargo' >
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

                <?php
                if ($authUser['ID_PERMISO']!=1) {
                    ?>
                    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">
                        <label>Area</label>
                        <select name='id_area' class='selectpicker selectField' placeholder='Seleccione Cargo'>
                            <option value=""></option>

                            <?php
                            foreach ($areas as $area) {
                                $selected = $registroEdit['ID_AREA'] == $area["ID_AREA"] ? "selected" : "";
                                ?>
                                <option value="<?= $area["ID_AREA"]; ?>" <?= $selected ?>><?= $area["AREA"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                    </div>
                    <?php
                }
                ?>


<!--                <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4">-->
<!--                    <label>Estado</label>-->
<!--                    <select class="selectpicker selectField" name="estado" ">-->
<!--                        <option value="ACTIVO" --><?//=$registroEdit['ESTADO']=='ACTIVO' ? 'selected' : ''?><!-- >-->
<!--                            ACTIVO-->
<!--                        </option>-->
<!--                        <option value="INACTIVO" --><?//=$registroEdit['ESTADO']=='INACTIVO' ? 'selected' : ''?><!-- >-->
<!--                            INACTIVO-->
<!--                        </option>-->
<!--                    </select>-->
<!--                </div>-->



            </div>

            </div>

            <div class="card-footer">
            <div class="row">
                <div class="col-sm-8">
                    <input type="hidden" name="submit" value="true">
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

            var selectRol = $('#selectRol').selectize({

                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                dropdownParent: 'body',
                onChange: function(value) {

                    visibleDivCargo(value)
                },
            });

            visibleDivCargo(selectRol.val())


            function visibleDivCargo(value) {
                if(value != "2"){
                    $('#divCargo').hide();
                } else {
                    $('#divCargo').show();
                }
            }
        </script>


        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;


	}
}