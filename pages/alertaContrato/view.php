<?php



namespace AlertaContrato;

/**
 * pagina 404, vista solo retorna mensaje de 404
 */
class ViewAlertaContrato {
	
	public function output(\AlertaContrato\ModelAlertaContrato $model){
		

		$data = $model->get();
		$filas = $data[0];
		$total = $data[1];




		$output = "";

		ob_start();

		?>



		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?=base("alertaContrato");?>">Contratos</a>
			</li>
			<li class="breadcrumb-item active">Alertas</li>
		</ol>

		<!-- DataTables Example -->
		<div class="card mb-3">
			<div class="card-header">
				<form method="get" class="form-horizontal" action="{{ route('alertaContrato.index') }}">
					<!-- {!! csrf_field() !!} -->
					<div class="btn-group float-right ml-3">
						<a href="{{ route('alertaContrato.mostrarTodos') }}" class="btn btn-warning rounded">Mostrar todos</a>
					</div>
					<div class="btn-group float-left">
						<i class="fas fa-table"> Registros</i>
					</div>
				</form>
			</div>

			<div class="card-body">
				<!-- @if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif -->
				<div class="table-responsive">
					<table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Rut Proveedor</th>
								<th>Razón social Proveedor</th>
								<th>Alerta término contrato</th>
								<th>Contrato</th>
								<th>Alerta boleta de garantía</th>
								<th>Boleta</th>
								<th>Ver</th>
							</tr>
						</thead>
						<!-- @foreach($contratosData as $contratosItem) -->
						<?php
							print_r($filas);
						foreach ($filas as $fila) {
						?>
						<tr>
							<td> <?= $filas["RUT"]; ?> </td>
							<td> <?= $filas["RAZON_SOCIAL"]; ?> </td>

							<!-- cálculo de termino de contrato -->
							<?php
/*
							$fecha_termino_contrato = new DateTime($contratosItem->fecha_termino);
							$fecha_alerta_contrato = new DateTime($contratosItem->alerta_vencimiento);
							$fecha_now = null = new DateTime("now");
							$diff = $fecha_now->diff($fecha_termino_contrato);
*/							
							$fecha_termino_contrato = new \DateTime();
							$fecha_alerta_contrato = new \DateTime();
							$fecha_now = new \DateTime("now");
							$diff = $fecha_now->diff($fecha_termino_contrato);

							if($filas["ALERTA_VENCIMIENTO"] == null){
								?>
								<td style="color:#05a303"><b>Sin alerta</b></td>
								<?php
							}elseif ($filas["ESTADO_ALERTA"] == "RESUELTO") {
								?>
								<td style="color:#05a303"><b>Resuelto</b></td>
								<?php
							}else{
								if($fecha_now <= $fecha_termino_contrato || $diff->days){
									if ($fecha_now > $fecha_termino_contrato) {
										?>
										<td style="color:#e58806"> <b>Contrato caduca hoy</b></td>
										<?php
									}elseif ($fecha_now >= $fecha_alerta_contrato){
										?>
										<td style="color:#e58806"> <b>Contrato caduca en {{ $diff->days+1}} días</b></td>
										<?php
									}else{
										?>
										<td style="color:#05a303"><b>No se ha alcanzado la fecha de alerta</b></td>                         
										<?php
									}
								}else{
									?>
									<td style="color:#ff0000"><b>Contrato caducado</b></td>
									<?php
								}
							}
							?>
							<!-- @if($contratosItem->alerta_vencimiento == null)

							@elseif($contratosItem->estado_alerta == 'resuelto')
							@else
								@if($fecha_now <= $fecha_termino_contrato || $diff->days == 0)
									@if($fecha_now > $fecha_termino_contrato)
									@elseif($fecha_now >= $fecha_alerta_contrato)
									@else
									@endif
								@else
								@endif
							@endif -->

							<td>
								<?php
								// if($contratosItem->estado_alerta == 'visto'){
								if($filas["ESTADO_ALERTA"] == 'visto'){
								?>
									<a href="#" class="btn btn-success btn-xs" data-target="#recuperarVistoContratoModal{{ $contratosItem->id }}" data-toggle="modal"> Recuperar</a>
								<!-- @else -->
								<?php
								}else{
								?>
									<a href="#" class="btn btn-warning btn-xs" data-target="#resolverContratoModal{{ $contratosItem->id }}" data-toggle="modal"> Resolver</a>
								<!-- @endif -->
								<?php
								}
								?>
							</td>
							<!-- cálculo de vencimiento de boleta -->
							<?php
							/*
							$fecha_vencimiento = new \DateTime($contratosItem->boletas->fecha_vencimiento);
							$fecha_alerta_boleta = new \DateTime($contratosItem->boletas->alerta_vencimiento);
							$diff = $fecha_now->diff($fecha_vencimiento);
							*/
							$fecha_vencimiento = new \DateTime();
							$fecha_alerta_boleta = new \DateTime();
							$diff = $fecha_now->diff($fecha_vencimiento);
							
							if($contratosItem->boletas->alerta_vencimiento == null && $contratosItem->boletas->estado_alerta != 'resuelto'){
								?>
								<td style="color:#05a303"><b>Sin alerta</b></td>
								<?php
							}elseif ($contratosItem->boletas->alerta_vencimiento == null && $contratosItem->boletas->estado_alerta != 'resuelto'){
								?>
								<td style="color:#05a303"><b>Resuelto</b></td>
								<?php
							}else{
								if ($fecha_now <= $fecha_vencimiento || $diff->days == 0) {
									if($fecha_now > $fecha_vencimiento){
										?>
										<td style="color:#e58806"> <b>Boleta vence hoy</b></td>
										<?php
									}elseif ($fecha_now >= $fecha_alerta_boleta) {
										?>
										<td style="color:#e58806"><b> Boleta vence en {{ $diff->days+1}} días</b></td>
										<?php
									}else{
										?>
										<td style="color:#05a303"><b>No se ha alcanzado la fecha de alerta</b></td>                              
										<?php

									}
								}else{
									?>
									<td style="color:#ff0000"><b>Boleta vencida</b></td>
									<?php
								}
							}
							?>
							<!-- @if($contratosItem->boletas->alerta_vencimiento == null && $contratosItem->boletas->estado_alerta != 'resuelto')
							@elseif($contratosItem->boletas->estado_alerta == 'resuelto')
							@else
								@if($fecha_now <= $fecha_vencimiento || $diff->days == 0)
									@if($fecha_now > $fecha_vencimiento)
									@elseif($fecha_now >= $fecha_alerta_boleta)
									@else
									@endif
								@else
								@endif
							@endif -->

							<td>
								<?php
								if($contratosItem->boletas->estado_alerta == 'visto'){
									?>
									<a href="#" class="btn btn-success btn-xs" data-target="#recuperarVistoBoletaModal{{ $contratosItem->id }}" data-toggle="modal"> Recuperar</a>
									<?php
								}else{
									?>
									<a href="#" class="btn btn-warning btn-xs" data-target="#resolverBoletaModal{{ $contratosItem->id }}" data-toggle="modal"> Resolver</a>
									<?php
								}
								?>
								<!-- @if($contratosItem->boletas->estado_alerta == 'visto')
								@else
								@endif -->
							</td>

							<td>    
								<a href="{{ route('hitoContrato.index', $contratosItem->id) }}" class="btn btn-warning btn-xs"> Hitos</a>
							</td>

							<!-- modal resolver visto starts -->
							<div class="modal fade" id="resolverContratoModal{{ $contratosItem->id }}">
								<div class="modal-dialog">
									 <div class="modal-content">
										<form class="form-horizontal" method="post" action="{{ route('alertaContrato.resolverContrato', $contratosItem->id) }}" >
											{!! csrf_field() !!}
											<div class="modal-header">
												<h4 class="modal-title"> Resolver contrato ?</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-default">Continuar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- modal resolver visto ends -->

							<!-- modal recuperar visto starts -->
							<div class="modal fade" id="recuperarVistoContratoModal{{ $contratosItem->id }}">
								<div class="modal-dialog">
									<div class="modal-content">
										<form class="form-horizontal" method="post" action="{{ route('alertaContrato.recuperarContrato', $contratosItem->id) }}" >
											<!-- {!! csrf_field() !!} -->
											<div class="modal-header">
												<h4 class="modal-title"> Recuperar contrato ?</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-default">Continuar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- modal recuperar visto ends -->

							<!-- modal resolver boleta visto starts -->
							<div class="modal fade" id="resolverBoletaModal{{ $contratosItem->id }}">
								<div class="modal-dialog">
									<div class="modal-content">
										<form class="form-horizontal" method="post" action="{{ route('alertaContrato.resolverBoletaContrato', $contratosItem->id) }}" >
											<!-- {!! csrf_field() !!} -->
											<div class="modal-header">
												<h4 class="modal-title"> Resolver boleta ?</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-default">Continuar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- modal resolver boleta visto ends -->

							<!-- modal recuperar visto starts -->
							<div class="modal fade" id="recuperarVistoBoletaModal{{ $contratosItem->id }}">
								<div class="modal-dialog">
									<div class="modal-content">
										<form class="form-horizontal" method="post" action="{{ route('alertaContrato.recuperarBoletaContrato', $contratosItem->id) }}" >
											<!-- {!! csrf_field() !!} -->
											<div class="modal-header">
												<h4 class="modal-title"> Recuperar boleta ?</h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-default">Continuar</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- modal recuperar visto ends -->

						</tr>
						<!-- @endforeach -->
						<?php
						}
						?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="card-footer">
		<?= paginador($data, "");?>
	</div>
</div>



<?php

	$output = ob_get_contents();
	ob_end_clean();


	return $output;

	}
}