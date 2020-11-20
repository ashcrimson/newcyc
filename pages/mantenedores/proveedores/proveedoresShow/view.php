<?php

   
 
namespace ProveedoresShow;


/**
 * clase vista, retorna html con lo recuperado desde el modelo
 */
class ViewProveedores {  
	
	public function output(ModelProveedores $model){

		
		if(isset($_GET["id"])){
            $proveedor = $model->get();
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
                <table>
                <tr>
                    <td>RUT PROVEEDOR</td>
                    <td><?=$proveedor["RUT_PROVEEDOR"]?></td>
                </tr>
                <tr>
                    <td>PROVEEDOR</td>
                    <td><?=$proveedor["RAZON_SOCIAL"]?></td>
                </tr>
                </table>
			</div>
					
					<br>    

					<div class="card-footer">
						<div class="row">
							<div class="col-sm-8">
                                <table class="table table-bordered"  class="table-sm w-25" id="dataBitacoras" width=100% cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>TELEFONO</th>
                                            <th>EMAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

					
						        <?php foreach($proveedor["CONTACTO"] as  $contacto){?>
                                        <tr>
                                            <td> <?= $contacto["NOMBRE"]; ?></td>
                                            <td> <?= $contacto["TELEFONO"]; ?></td>
                                            <td> <?= $contacto["EMAIL"]; ?></td>
                                        </tr>
						        <?php }?>
						
							
					</tbody>
				</table>
                                
							</div>
						</div>
						
					</div>

				</form>
			</div>
		</div>

		

		<script src="<?=base();?>/assets/assets/frontend/js/jquery-3.3.1.js"></script>
		<script src="<?=base();?>/assets/assets/frontend/js/selectize.js"></script>
		 





<hr>




		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
//		return "";

	}
}