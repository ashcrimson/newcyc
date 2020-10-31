<?php

//convierte a arreglo asociativo resultado de bd
function queryResultToAssoc($result):array {	
	$arreglo = [];
	while ($paso = oci_fetch_assoc($result)) {
		array_push($arreglo, $paso);
	}
	return $arreglo;
}


//genera query encapsulada para tener paginado
function queryPagination(string $query, int $page = 1, int $resultados = 10):string {
	//calculo de paginado
	$fin = $page * $resultados;
	$inicio =  $fin - $resultados;

	//completa query
	$fullQuery = "
	select * from (
		select consulta.*, rownum rn from (
		" .
		$query
		. "
		) consulta 
		where rownum <= " . $fin . "
	) cosnulta
	where rn > " . $inicio . "
	";

	return $fullQuery;
}

//genera html con paginador segun los parametros indicados
function paginador($result, string $ruta, int $resultados = 10){
	//calculo cuantas paginas
	$paginas = ceil(count($result) / $resultados);
	if(isset($_GET["page"]) && $_GET["page"] > 1){
		$pos = $_GET["page"];
	}else{
		$pos =  1;
	}

	//"renderiza" paginacion si hay más de 1 página
	if($paginas > 1){
		?>
		<ul class="pagination" role="navigation">
			<?php
			//botón de pagina previa
			if($pos == 1){
				?>
			    <li class="page-item disabled" aria-disabled="true" aria-label="« Anterior">
			        <span class="page-link" aria-hidden="true">‹</span>
			    </li>
				<?php 
			}else{
				?>
			    <li class="page-item" aria-disabled="true" aria-label="« Anterior">
			        <a class="page-link" href="<?=$ruta?>?page=<?=$pos-1?>" rel="prev" aria-label="« Anterior">‹</a>
			    </li>
				<?php 
			}

			//botones para cada página
			for ($i=1; $i <= $paginas; $i++) { 
				if($i == $pos){
					?>
					<li class="page-item active" aria-current="page"><span class="page-link"><?=$i;?></span></li>
					<?php
				}else{
					?>
					<li class="page-item"><a class="page-link" href="<?=$ruta?>?page=<?=$i;?>"><?=$i;?></a></li>
					<?php
				}
			}

			//botón de pagina siguiente
			if($pos == $paginas){
				?>
			    <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente »">
			        <span class="page-link" aria-hidden="true">›</span>
			    </li>
				<?php 
			}else{
				?>
			    <li class="page-item" aria-disabled="true" aria-label="Siguiente »">
			        <a class="page-link" href="<?=$ruta?>?page=<?=$pos+1?>" rel="next" aria-label="Siguiente »">›</a>
			    </li>
				<?php 
			}
			?>
		</ul>
		<?php
	}
}

//obtiene ruta base de ejecucion
function base(string $ruta = ""){
	return substr($_SERVER["SCRIPT_NAME"], 0, -10) . $ruta;
}

function feedback(){
    if(isset($_SESSION["feedback"])){
        echo "
		<div class='alert alert-primary' role='alert'>
		{$_SESSION["feedback"]} 
		</div>
		";
		unset($_SESSION["feedback"]);
	}
}