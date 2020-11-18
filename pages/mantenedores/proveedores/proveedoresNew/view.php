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
            $registroEdit = $model->get();
        }



        $dataListBox = $model->getDataListBox();

		$dataProveedores = $dataListBox[0];
		

		$rut = false;
        $nombre = false;
        $nombre_fantasia = false;
        $telefono = false;
        $email = false;
        $direccion = false;
        $comuna = false;



        if(sizeof($_GET) && !isset($_GET["id"])){
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

		

		ob_start();

		?>




		<!-- Habilitar nombre de archivo adjunto-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

		<?php
		//valida si es admin
		?>
		<!-- Breadcrumbs-->

		
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
                <a href="<?=base("/proveedores/");?>">Proveedores</a>
			</li>
            <li class="breadcrumb-item active">Mantenedor</li>
		</ol>

		<div class="card mb-3">
			<div class="card-header">
				<form method="post" class="form-horizontal" action="<?=base();?>/proveedores/new" enctype="multipart/form-data">
					
                    <div class="container">
                    <?php feedback();?>
						<div class="row col-12">
						    <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$rut ? 'has-error' : '' ;?>">
                                <label>RUT del proveedor *</label>
                                
                                <input type="text" name="rut" class="form-control"
                                    value="<?=$_GET["rut"] ?? $registroEdit["rut"] ?? ''?>"
                                    oninput="checkRut(this)"
                                >
                                <?php if ($rut){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: RUT vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$nombre? 'has-error' : '' ;?>">
                                <label>Razón Social *</label>
                                
                                <input type="text" name="nombre" class="form-control"
                                    value="<?=$_GET["nombre"] ?? $registroEdit["nombre"] ?? ''?>"
                                >
                                <?php if ($nombre){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Razón Social vacía</strong>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$nombre_fantasia ? 'has-error' : '' ;?>">
                                <label>Nombre Fantasía *</label>
                                
                                <input type="text" name="nombre_fantasia" class="form-control"
                                    value="<?=$_GET["nombre_fantasia"] ?? $registroEdit["nombre_fantasia"] ?? ''?>"
                                >
                                <?php if ($nombre_fantasia){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Razón Social vacía</strong>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$telefono ? 'has-error' : '' ;?>">
                                <label>Teléfono*</label>
                                
                                <input type="text" name="telefono" class="form-control"
                                    value="<?=$_GET["telefono"] ?? $registroEdit["telefono"] ?? ''?>"
                                >
                                <?php if ($telefono){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Teléfono vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$email ? 'has-error' : '' ;?>">
                                <label>E-mail*</label>
                                
                                <input type="text" name="email" class="form-control"
                                    value="<?=$_GET["email"] ?? $registroEdit["email"] ?? ''?>"
                                >
                                <?php if ($email){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: E-mail vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$direccion ? 'has-error' : '' ;?>">
                                <label>Dirección*</label>
                                
                                <input type="text" name="direccion" class="form-control"
                                    value="<?=$_GET["direccion"] ?? $registroEdit["direccion"] ?? ''?>"
                                >
                                <?php if ($direccion){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Dirección vacía</strong>
                                </span>
                                <?php } ?>
                            </div>
                            <div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$comuna ? 'has-error' : '' ;?>">
                                <label>Comuna*</label>
                                
                                <input type="text" name="comuna" class="form-control"
                                    value="<?=$_GET["comuna"] ?? $registroEdit["comuna"] ?? ''?>"
                                >
                                <?php if ($comuna){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Comuna vacía</strong>
                                </span>
                                <?php } ?>
                            </div>
						</div>
					</div>
			</div>
					
					<br>    

					<div class="card-footer">
						<div class="row">
							<div class="col-sm-8">
                                <input type="hidden" name="id" value="<?= $_GET["id"] ?? "" ?>" >
								<button type="submit" class="btn-primary btn rounded" >
                                    <i class="icon-floppy-disk"></i> Guardar
                                </button>
							</div>
						</div>
						
					</div>

				</form>
			</div>
		</div>

		<!-- {{-- Script para mostrar nombre archivo en el select --}} -->
		<script>
			$(".custom-file-input").on("change", function() {
				var fileName = $(this).val().split("\\").pop();
				$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});
		</script>

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
					if(value == "td"){
						$('#licitacion').hide(); 
					} else {
						$('#licitacion').show(); 
					}
					// console.log("Cambio", value);
				}
			});
		</script> 





<hr>

<script>
function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
}
</script>

<script>
function fecha(){
	var fecha_inicio = document.getElementById("fecha_inicio").value;
	var fecha_termino = document.getElementById("fecha_termino").value;

	if (fecha_inicio >= fecha_termino) {
    	document.getElementById("error_fecha").style.display = "block";
  	} else {
    	document.getElementById("error_fecha").style.display = "none";
	  }

}
</script>

<script>
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2; 
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index; 
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
</script>




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}