<?php

 
 
namespace PrestacionesNew;


/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewPrestaciones {
	
	public function output(\PrestacionesNew\ModelPrestaciones $model){

		if(!empty($_POST)){
			$model->execute();
		}

		if(isset($_GET["codigo"])){
            $registroEdit = $model->get();
        }



        $dataListBox = $model->getDataListBox();

		$dataPrestaciones = $dataListBox[0];
		

		$codigo = false;
        $nombre = false;
        

        if(sizeof($_GET) && !isset($_GET["codigo"])){
			if(!isset($_GET["codigo"])){
				$codigo = !$codigo;
			}
			if(!isset($_GET["nombre"])){
				$nombre = !$nombre;
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
                <a href="<?=base("/prestaciones/");?>" class="encabezado">Prestaciones</a>
			</li>
            
		</ol> 
 
		<div class="card mb-3">
			<div class="card-header">
				<form method="post" class="form-horizontal" action="<?=base();?>/prestaciones/new" enctype="multipart/form-data">
					
                    <div class="container">
                        <?php
                        feedback();
                        ?>
						<div class="row col-12">
						    <div class="form-group has-feedback <?=$codigo ? 'has-error' : '' ;?>">
                                <label>Código Prestación *</label>
                                <input type="text" name="code" class="form-control"
                                value="<?=$_GET["code"] ?? $registroEdit["CODIGO"] ?? "";?>"
                                >
                                    
                                <?php if ($codigo){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Código vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
						</div>

						<div class="row col-12">
                            <div class="form-group has-feedback <?=$nombre? 'has-error' : '' ;?>">
                                <label>Nombre *</label>
                                
                                <input type="text" name="nombre" class="form-control"
                                    value="<?=$_GET["nombre"] ?? $registroEdit["NOMBRE"] ?? ''?>"
                                >
                                <?php if ($nombre){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Nombre vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
						</div>
						<div class="row col-12">
							<div class="form-group has-feedback col-xs-4 col-md-4 col-lg-4 <?=$selectFonasa ? 'has-error' : '' ;?>">
								<label>FONASA</label>
								<input type="hidden" name="submit" value="true">
								<select class="selectpicker " placeholder='Seleccione Tipo de Contrato' name="selectFonasa" id="selectFonasa" value="<?=isset($_GET["selectFonasa"]) ? $_GET["selectFonasa"]: (isset($registroEdit["FONASA"]) ? $registroEdit["FONASA"] : "") ?>">
									<option value="si" <?=$registroEdit['FONASA']=='si' ? 'selected' : ''?> >Sí</option>
									<option value="no" <?=$registroEdit['FONASA']=='no' ? 'selected' : ''?>>No</option>
								</select>
								<?php if ($selectFonasa){ ?>
								<span class="help-block text-danger"> 
									<strong>Fonasa vacío</strong>
								</span>
								<?php } ?>
							</div>
            			</div>
						<div class="row col-12">
							<div class="form-group has-feedback <?=$valor_nivel_1? 'has-error' : '' ;?>">
                                <label>Valor Nivel 1</label>
                                
                                <input type="text" name="valor_nivel_1" class="form-control"
                                    value="<?=$_GET["valor_nivel_1"] ?? $registroEdit["VALOR_NIVEL_1"] ?? ''?>"
                                >
                                <?php if ($valor_nivel_1){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Valor vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
						</div>
						<div class="row col-12">
							<div class="form-group has-feedback <?=$valor_nivel_2? 'has-error' : '' ;?>">
                                <label>Valor Nivel 2</label>
                                
                                <input type="text" name="valor_nivel_2" class="form-control"
                                    value="<?=$_GET["valor_nivel_2"] ?? $registroEdit["VALOR_NIVEL_2"] ?? ''?>"
                                >
                                <?php if ($valor_nivel_2){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Valor vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
						</div>
						<div class="row col-12">
							<div class="form-group has-feedback <?=$valor_nivel_3? 'has-error' : '' ;?>">
                                <label>Valor Nivel 3</label>
                                
                                <input type="text" name="valor_nivel_3" class="form-control"
                                    value="<?=$_GET["valor_nivel_3"] ?? $registroEdit["VALOR_NIVEL_3"] ?? ''?>"
                                >
                                <?php if ($valor_nivel_3){ ?>
                                <span class="help-block text-danger"> 
                                    <strong>Error: Valor vacío</strong>
                                </span>
                                <?php } ?>
                            </div>
                        </div> 
                            
						</div>
					</div>
			</div>
					
					<br>    

					<div class="card-footer">
						<div class="row">
							<div class="col-sm-8">
                                <!-- <input type="hidden" name="codigo" value="<?= $_GET["codigo"] ?? "" ?>" > -->
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





		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}