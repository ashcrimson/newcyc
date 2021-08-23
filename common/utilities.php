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

    $simbolo = strpos($ruta, '?id') !== false ? "&" : "?";
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
                    <a class="page-link" href="<?= $ruta .$simbolo?>page=<?= $pos - 1 ?>" rel="prev" aria-label="« Anterior">‹</a>
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
					<li class="page-item"><a class="page-link" href="<?=$ruta.$simbolo?>page=<?=$i;?>"><?=$i;?></a></li>
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
			        <a class="page-link" href="<?=$ruta.$simbolo?>page=<?=$pos+1?>" rel="next" aria-label="Siguiente »">›</a>
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


function flash($message = null, $level = 'info')
{
    $notifier = new \Laracasts\Flash\FlashNotifier();

    if (! is_null($message)) {
        return $notifier->message($message, $level);
    }

    return $notifier;
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

function feedback2(){

    session_start();



    if (is_array($_SESSION['flash_notification'])){


        foreach ($_SESSION['flash_notification'] as $message){
            ?>
            <div class="alert
                    alert-<?=$message['level']?>
                    <?=$message['important'] ? 'alert-important' : '' ?>"
                 role="alert"
            >
                <?php
                if ($message['important']){
                    ?>
                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true"
                    >&times;</button>
                    <?php
                }

                echo  $message['message'];
                ?>
            </div>
            <?php
        }
        unset($_SESSION["flash_notification"]);
    }

}

function fechaEn($fecha=null){

    if (!$fecha)
        return null;

    $date =date_create_from_format("d/m/y", $fecha);

    return $date->format('Y-m-d');
}

function queryToArray($query=null,$pdo){

    if (!$query)
        return [];

    $result = oci_parse($pdo, $query);
    oci_execute($result);

    $res = queryResultToAssoc($result);

    oci_close($pdo);

    return $res;
}

function dd($variable){
	echo "<pre>";
	print_r($variable);
	echo "</pre>";
	echo "<br>";
	exit();
}

function dump($variable){
	echo "<pre>";
	print_r($variable);
	echo "</pre>";
	echo "<br>";
}

function authUser($pdo){

    session_start();
	if(!isset($_SESSION['mail'])){
		return false;
	}

	$query = "SELECT * FROM USUARIOS WHERE mail='".$_SESSION['mail']."'";

	$user = queryToArray($query,$pdo)[0];

    return $user;
}

function acentos($string){

	$string = str_replace(array("á", "é", "í", "ó", "ú","ñ"), array("a", "e", "i", "o", "u","n"), $string);
	return $string;
}

function redirect($ruta){
    header("Location: ". base() . $ruta);
    exit();
}

function toFloat($val){
    $val = str_replace(",",".",$val);
    $val = preg_replace('/\.(?=.*\.)/', '', $val);
    return floatval($val);
}

function dvs(){
    return "$";
}

function nfp($numero){
    $numero = toFloat($numero);
    return dvs().number_format($numero,2,',','.');
}

function errorsToList($errores){
    $res = "<ul>";

        foreach ($errores as $index => $error) {
            $res .= "<li>{$error}</li>";
        }

    $res .=  "</ul>";

    return $res;
}