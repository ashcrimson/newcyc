<?php
/**
 * pagina principal, captura las rutas y las traduce a las peticiones en el enrutador, 
 * tambien carga automaticamente todo lo necesario extra
 */

//para mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

//carga paginas individuales
require_directory_recursive("./pages");
//carga plantillas, y cosas comunes 
require_directory_recursive("./common");


$request = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : "";
//$request = $_SERVER['REDIRECT_URL'];


$router = new Router();

$base =  "/newcyc";

if ($_SERVER['HTTP_HOST']=='newcyc.local'){
    $base =  "";
    require './vendor/autoload.php';
}

//ruta base, cambiar cuando se tire a prod
// print_r($_SERVER);
//print_r($request);
//solicita la pagina pertinetente en base a la ruta
switch ($request) {
	case '' :
	case $base . '/home' :
	case $base . '/home/' :
		
		$router->home();
		
		break;
	case $base . '/login' :
	case $base . '/login/' :
		$router->login(); 
		break;
	case $base . '/logout' :
	case $base . '/logout/' :
		$router->logout(); 
		break;
	case $base . '/licitaciones' :
	case $base . '/licitaciones/' :
		$router->licitacionesList(); 
		break;
	case $base . '/licitaciones/new' :
	case $base . '/licitaciones/new/' :
		$router->licitacionesNew(); 
		break;
	case $base . '/contratos' :
	case $base . '/contratos/' :
	
    case $base . '/contratos/asignar/store' :
    case $base . '/contratos/asignar/store/' :
		$router->contratosList(); 
		break;

	case $base . '/contratos/new' :
	case $base . '/contratos/new/' :
		$router->contratosNew(); 
		break;
    case $base . '/get/detalles/contratos/ajax' :
    case $base . '/get/detalles/contratos/ajax/' :

        $router->getDetallesContratosAjax();

        exit();
 
        break;
    case $base . '/contratos/show' :
	case $base . '/contratos/show/' :
        $router->contratosShow();
		break;
	case $base . '/contratos/bitacora/show' :
	case $base . '/contratos/bitacora/show/' :
		$router->contratosBitacoraShow();
		break;
	case $base . '/contratos/bitacora/store' :
	case $base . '/contratos/bitacora/store/' :
		$router->contratosBitacoraStore();
		break;
	case $base . '/ordenCompra' :
	case $base . '/ordenCompra/' :
	// case $base . '/ordenCompra/delete' :
	// case $base . '/ordenCompra/delete/' :
	case $base . '/ordenCompra/anula' :
	case $base . '/ordenCompra/anula/' :	
		$router->ordenCompraList(); 
		break;
	case $base . '/ordenCompra/new' :
	case $base . '/ordenCompra/new/' :
	
		$router->ordenCompraNew(); 
		break;
	case $base . '/ordenCompra/save' :
	case $base . '/ordenCompra/save/' :

		$router->ordenCompraSave();
		break;
	case $base . '/ordenCompra/show' :
	case $base . '/ordenCompra/show/' :

		$router->ordenCompraShow();
		break;
	case $base . '/ordenCompra/detalles/delete' :

		$router->ordenCompraDetalleDelete();
		break;

    case $base . '/ordenCompra/detalles/add' :

        $router->ordenCompraDetalleAdd();
        break;

	case $base . '/alertaContrato' :
	case $base . '/alertaContrato/' :
		$router->alertaContrato(); 
		break;

	/** CARGOS **/
	case $base . '/cargos' :
	case $base . '/cargos/' :
	case $base . '/cargos/delete' :
	case $base . '/cargos/delete/' :
		$router->cargosList(); 
		break;
	case $base . '/cargos/new' :
	case $base . '/cargos/new/' :
	case $base . '/cargos/save' :
	case $base . '/cargos/save/' :
		$router->cargosNew(); 
		break;
	//edicion de cargos
	//case (preg_match("/\/cargos\/\d*\/edit\/{0,1}/", $base . $request) ? true : false) :
		$router->cargosNew(); 
		break;
	
		/** AREAS **/
	case $base . '/areas' :
	case $base . '/areas/' :
	case $base . '/areas/delete' :
	case $base . '/areas/delete/' :
		$router->areasList(); 
		break;
	case $base . '/areas/new' :
	case $base . '/areas/new/' :
	case $base . '/areas/save' :
	case $base . '/areas/save/' :
		$router->areasNew(); 
		break;
	//edicion de areass
	//case (preg_match("/\/areass\/\d*\/edit\/{0,1}/", $base . $request) ? true : false) :
		$router->areasNew(); 
		break;

	/** MONEDAS **/
	case $base . '/monedas' :
	case $base . '/monedas/' :
	case $base . '/monedas/delete' :
	case $base . '/monedas/delete/' :
		$router->monedasList(); 
		break;
	case $base . '/monedas/new' :
	case $base . '/monedas/new/' :
	case $base . '/monedas/save' :
	case $base . '/monedas/save/' :
		$router->monedasNew(); 
		break;
	//edicion de monedas
	//case (preg_match("/\/monedas\/\d*\/edit\/{0,1}/", $base . $request) ? true : false) :
		//$router->monedasNew(); 
		break;

	/** PROVEEDORES **/
	case $base . '/proveedores' :
	case $base . '/proveedores/' :
	case $base . '/proveedores/delete' :
	case $base . '/proveedores/delete/' :
		$router->proveedoresList(); 
		break;
	case $base . '/proveedores/new' :
	case $base . '/proveedores/new/' :
	case $base . '/proveedores/save' :
	case $base . '/proveedores/save/' :
		$router->proveedoresNew(); 
		break;
	case $base . '/proveedores/show' :
	case $base . '/proveedores/show/' :
		$router->proveedoresShow();
		break;
	//edicion de monedas
	//case (preg_match("/\/proveedores\/\d*\/edit\/{0,1}/", $base . $request) ? true : false) :
		//$router->proveedoresNew(); 
		break;

	/** PRESTACIONES **/
	case $base . '/prestaciones' :
	case $base . '/prestaciones/' :
	case $base . '/prestaciones/delete' :
	case $base . '/prestaciones/delete/' :
			$router->prestacionesList(); 
			break;
		case $base . '/prestaciones/new' :
		case $base . '/prestaciones/new/' :
		case $base . '/prestaciones/save' :
		case $base . '/prestaciones/save/' :
			$router->prestacionesNew(); 
			break;
		case $base . '/prestaciones/show' :
		case $base . '/prestaciones/show/' :
			$router->prestacionesShow();
			break;
		//edicion de monedas
		//case (preg_match("/\/proveedores\/\d*\/edit\/{0,1}/", $base . $request) ? true : false) :
			//$router->proveedoresNew(); 
			break;

	/** USERS **/
	case $base . '/usuarios' :
	case $base . '/usuarios/' :
	case $base . '/usuarios/delete' :
	case $base . '/usuarios/delete/' :
		$router->usuariosList(); 
		break;
	case $base . '/usuarios/new' :
	case $base . '/usuarios/new/' :
	case $base . '/usuarios/save' :
	case $base . '/usuarios/save/' :
		$router->usuariosNew(); 
		break;

    case $base . '/archivo/download/':
	case $base . '/archivo/download' :
		
        $router->archivoDownload();

		break;
		
	case $base . '/contacto/' :

		$router->contacto();

		break;

	case $base . '/detalle' :	
	case $base . '/detalle/' :

		$router->detalle();

		break;


	//edicion de monedas
	//case (preg_match("/\/usuarios\/\d*\/edit\/{0,1}/", $base . $request) ? true : false) :
		//$router->usuariosNew(); 
		break;

	default:
		
		$router->notFound();
	break;
}
//"renderiza" la pagina resultante dentro de la plantilla

$router->display();





/**
 *Importa recursivamente todos los php que se encuentren en el directorio especificado, 
 */
function require_directory_recursive($directory){
	if(is_dir($directory) && $directory != ".." && $directory != "."){
		$files = scandir($directory, 1);
		if($files){
			foreach ($files as $file) {
				if($file != ".." && $file != "." ){
					require_directory_recursive($directory . "/" . $file);
				}
			}
		}
	}else{
		$file = pathinfo($directory);
		if( $file["extension"] == "php" && $file["basename"] != "index.php"){
			//print_r($directory . "\n<br>");
			require_once($directory);
		}else{
			//?
		}
	}
}