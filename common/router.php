<?php


/**
 * maneja el llamado de las distintas páginas de la web  y la conexiona a la bd :D, no se por que me dio por hacerla clase :P
 */
class Router{
	
	private $pdo;
	private $model;
	private $view;
	private $controller;
	private $templateModel;
	private $templateView;
	private $templateController;

	function __construct(){
		$db_username = "admincontratos";
		$db_password = "admincontratos";
		$db_ip = "172.25.16.24";
		$db_port = "1521";
		$tns = "(DESCRIPTION = 
					(ADDRESS = 
						(PROTOCOL = TCP)
						(HOST = " . $db_ip . ")
						(PORT = " . $db_port . ")
					) 
					(CONNECT_DATA = 
						(SERVICE_NAME = XE) 
						(SID = lawen)
					)
				)";
        $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.16.24)(PORT = 1521)))(CONNECT_DATA=(SID=lawen)))" ;

        if ($_SERVER['HTTP_HOST']=='newcyc.local') {
            $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))";
        }
		try{
			$connect = oci_connect("admincontratos", "admincontratos", $db);
			$this->pdo = $connect;
		}catch(PDOException $e){
		    echo ($e->getMessage());
		}
//		$this->pdo = new \Pdo('mysql:host=v.je;dbname=' . DB_SCHEMA, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	}




	/***********************************
	 * LICITACIONES
	 ***********************************/
	//pagina de listado de licitaciones
	public function licitacionesList(){
		$this->model = new \LicitacionesList\ModelLicitaciones($this->pdo);
		$this->view = new \LicitacionesList\ViewLicitaciones;
		$this->controller = new \LicitacionesList\ControllerLicitaciones;
		
		$this->model = $this->controller->all($this->model);
		
		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}

		if(isset($_GET['id'])){
            $this->model = $this->controller->filter($this->model);
        }
	}

	//pagina agregado de licitaciones
	public function licitacionesNew(){
		$this->model = new \LicitacionesNew\ModelLicitaciones($this->pdo);
		$this->view = new \LicitacionesNew\ViewLicitaciones;
		$this->controller = new \LicitacionesNew\ControllerLicitaciones;

		if(!empty($_GET["id"])){
            $this->model = $this->controller->edit($this->model);
        }

		if(!empty($_POST["submit"])){
			$this->model = $this->controller->new($this->model);
		}else {
			$this->model = $this->controller->all($this->model);
		}
	}

	/***********************************
	 * Contratos
	 ***********************************/
	//pagina listado contratos
	public function contratosList(){
		$this->model = new \ContratosList\ModelContratos($this->pdo);
		$this->view = new \ContratosList\ViewContratos;
		$this->controller = new \ContratosList\ControllerContratos;
		$this->model = $this->controller->all($this->model);
		if(isset($_GET["page"])){
            $this->model = $this->controller->page($this->model);
        }

        if(isset($_POST["save_bitacora"])){
            $this->model = $this->controller->saveBitacora($this->model);
        }

        if(isset($_POST["asignar"])){
            $this->model = $this->controller->asignar($this->model);
        }

        if(isset($_GET['id_contrato'])){
            $this->model = $this->controller->filter($this->model);
        }
	}

    //pagina listado contratos
    public function asignaContrato(){
        $this->model = new \ContratosList\ModelContratos($this->pdo);
    }

	//pagina agregado de contratos
	public function contratosNew(){


		$this->model = new \ContratosNew\ModelContratos($this->pdo);
		$this->view = new \ContratosNew\ViewContratos;
		$this->controller = new \ContratosNew\ControllerContratos;
		$this->model = $this->controller->all($this->model);
        if(!empty($_POST["submit"])){
            $this->model = $this->controller->new($this->model);
        }else {
            $this->model = $this->controller->all($this->model);
        }

		//si no esta vacío el dato id de la url
        if(!empty($_GET["id"] && $_GET["id"] >= 1)){
            $this->model = $this->controller->edit($this->model);
        }
	}

    public function getDetallesContratosAjax()
    {

        $id = $_POST['id'] ?? $_GET['id'];

        $query = 'select * from detalle_contrato where id_contrato='.$id;

        $result = queryToArray($query,$this->pdo);

        $detalles = [];

        if ($result){


            foreach ($result as $index => $item) {
                $codigo = $item['CODIGO'];
                $nombre = $item['CODIGO']." / ".$item['DESC_PROD_SOLI']." / ".$item['DESC_TEC_PROD_OFERTADO'];
                $precio = $item['PRECIO_U_BRUTO'];
                $saldo = $item['SALDO'];

                $detalles[] = [
                    'id' => $codigo,
                    'nombre' => utf8_encode($nombre),
                    'precio' => $precio,
                    'saldo' => $saldo
                ];
            }

        }


        echo json_encode($detalles);


	}


    public function contratosShow(){


        $this->model = new \contratosShow\ModelContratos($this->pdo);
        $this->view = new \contratosShow\ViewContratos;
		$this->controller = new \contratosShow\ControllerContratos;
        $this->model = $this->controller->all($this->model);

        //si no esta vacío el dato id de la url
        if(!empty($_GET["id"] && $_GET["id"] >= 1)){
            $this->model = $this->controller->show($this->model);
        }

        if(isset($_GET["page"])){
            $this->model = $this->controller->page($this->model);
		}
		
		if(isset($_GET['id'])){
            $this->model = $this->controller->filter($this->model);
        }
	}
	
	public function contratosBitacoraShow(){


        $this->model = new \ContratosBitacoraShow\ModelContratos($this->pdo);
        $this->view = new \ContratosBitacoraShow\ViewContratos();
        $this->controller = new \ContratosBitacoraShow\ControllerContratos();
        $this->model = $this->controller->show($this->model);

        if(isset($_GET["page"])){
            $this->model = $this->controller->page($this->model);
		}
//
//		if(isset($_GET['id'])){
//            $this->model = $this->controller->filter($this->model);
//		}

    }

    public function contratosBitacoraStore()
    {

        $model = new \ContratosBitacoraShow\ModelContratos($this->pdo);

        $model->saveBitacora();
    }



	/***********************************
	 * ordenes compra
	 ***********************************/
	//pagina listado ordenes compra 
	public function ordenCompraList(){
		$this->model = new \OrdenCompraList\ModelOrdenCompra($this->pdo);
		$this->view = new \OrdenCompraList\ViewOrdenCompra;
		$this->controller = new \OrdenCompraList\ControllerOrdenCompra;
		$this->model = $this->controller->all($this->model);

		if(!empty($_GET["anula"])){
            $this->controller->anula($this->model);
		}
		if(isset($_GET["page"])){
            $this->model = $this->controller->page($this->model);
		}
		
		if(isset($_GET['ordenes_compra'])){
            $this->model = $this->controller->filter($this->model);
        }
	}

	//pagina agregado de ordenes compra
	public function ordenCompraNew(){
		$this->model = new \OrdenCompraNew\ModelOrdenCompra($this->pdo);
		$this->view = new \OrdenCompraNew\ViewOrdenCompra;
		$this->controller = new \OrdenCompraNew\ControllerOrdenCompra;
		$this->model = $this->controller->all($this->model);
		if(!empty($_POST["submit"])){
			$this->model = $this->controller->new($this->model);
		}else {
			$this->model = $this->controller->all($this->model);
		}

		// if(!empty($_GET["nro_orden_compra"] && $_GET["nro_orden_compra"] >= 1)){
        //     $this->model = $this->controller->edit($this->model);
		// }
		
		if(!empty($_GET["nro_orden_compra"])){
			$this->model = $this->controller->edit($this->model);
		}
	}

    public function ordenCompraSave()
    {
        $model = new \OrdenCompraNew\ModelOrdenCompra($this->pdo);

        $model->new();
        $model->execute();
	}


    public function ordenCompraShow(){


        $this->model = new \OrdenCompraShow\ModelOrdenCompraShow($this->pdo);
        $this->view = new \OrdenCompraShow\ViewOrdenCompraShow();
        $this->controller = new \OrdenCompraShow\ControllerOrdenCompraShow();
        $this->model = $this->controller->show($this->model);

    }


    public function ordenCompraDetalleDelete()
    {
        $model = new \OrdenCompraNew\ModelOrdenCompra($this->pdo);

        $model->detalleDelete();
	}

	public function ordenCompraDetalleAdd()
    {
        $model = new \OrdenCompraNew\ModelOrdenCompra($this->pdo);

        $model->detalleAdd();
	}



	/***********************************
	 * alerta contrato
	 ***********************************/
	//pagina listado alerta contrato
	public function alertaContrato(){
		$this->model = new \AlertaContrato\ModelAlertaContrato($this->pdo);
		$this->view = new \AlertaContrato\ViewAlertaContrato;
		$this->controller = new \AlertaContrato\ControllerAlertaContrato;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id_contrato"])){
			$this->model = $this->controller->filter($this->model);
		}
		if(isset($_GET["page"])){
            $this->model = $this->controller->page($this->model);
		}
		
		if(isset($_GET['id_contrato'])){
            $this->model = $this->controller->filter($this->model);
        }
	}

	//pagina agregado de alerta contrato
	public function alertaContratoMostrar(){
		$this->model = new \AlertaContrato\ModelAlertaContrato($this->pdo);
		$this->view = new \AlertaContrato\ViewAlertaContrato;
		$this->controller = new \AlertaContrato\ControllerAlertaContrato;
		$this->model = $this->controller->Mostrar($this->model);
	}



	/***********************************
	 * mantenedor cargos
	 ***********************************/
	//pagina listado de cargos
	public function cargosList(){
		$this->model = new \CargosList\ModelCargos($this->pdo);
		$this->view = new \CargosList\ViewCargos;
		$this->controller = new \CargosList\ControllerCargos;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["tipo"])){
			$this->model = $this->controller->filter($this->model);
		}

		if(!empty($_GET["id"])){
            $this->controller->delete($this->model);
		}
		
		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}
	}

	//pagina agregado de cargos
	public function cargosNew(){
		$this->model = new \CargosNew\ModelCargos($this->pdo);
		$this->view = new \CargosNew\ViewCargos;
		$this->controller = new \CargosNew\ControllerCargos;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->edit($this->model);
		}
	}

	/***********************************
	 * mantenedor areas
	 ***********************************/
	//pagina listado de areas
	public function areasList(){
		$this->model = new \AreasList\ModelAreas($this->pdo);
		$this->view = new \AreasList\ViewAreas;
		$this->controller = new \AreasList\ControllerAreas;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["tipo"])){
			$this->model = $this->controller->filter($this->model);
		}

		if(!empty($_GET["id"])){
            $this->controller->delete($this->model);
		}
		
		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}
	}

	//pagina agregado de areas
	public function areasNew(){
		$this->model = new \AreasNew\ModelAreas($this->pdo);
		$this->view = new \AreasNew\ViewAreas;
		$this->controller = new \AreasNew\ControllerAreas;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->edit($this->model);
		}
	}



	/***********************************
	 * mantenedor Monedas
	 ***********************************/
	//pagina listado de monedas
	public function monedasList(){
		$this->model = new \MonedasList\ModelMonedas($this->pdo);
		$this->view = new \MonedasList\ViewMonedas;
		$this->controller = new \MonedasList\ControllerMonedas;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["tipo"])){
			$this->model = $this->controller->filter($this->model);
		}
		if(!empty($_GET["id"])){
            $this->controller->delete($this->model);
        }
		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}
	}

	//pagina agregado de monedas
	public function monedasNew(){
		$this->model = new \MonedasNew\ModelMonedas($this->pdo);
		$this->view = new \MonedasNew\ViewMonedas;
		$this->controller = new \MonedasNew\ControllerMonedas;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->edit($this->model);
		}
	}

 

	/***********************************
	 * mantenedor proveedores
	 ***********************************/
	//pagina listado de proveedores
	public function proveedoresList(){
		$this->model = new \proveedoresList\ModelProveedores($this->pdo);
		$this->view = new \proveedoresList\ViewProveedores;
		$this->controller = new \proveedoresList\ControllerProveedores;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->filter($this->model);
		}
		if(!empty($_GET["id"])){
            $this->controller->delete($this->model);
		}
		
		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}
	}

	//pagina agregado de proveedores
	public function proveedoresNew(){
		$this->model = new \proveedoresNew\ModelProveedores($this->pdo);
		$this->view = new \proveedoresNew\ViewProveedores;
		$this->controller = new \proveedoresNew\ControllerProveedores;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->edit($this->model);
		}
	}

	public function proveedoresShow(){


        $this->model = new \proveedoresShow\ModelProveedores($this->pdo);
        $this->view = new \proveedoresShow\ViewProveedores;
        $this->controller = new \proveedoresShow\ControllerProveedores;

        //si no esta vacío el dato id de la url
        if(!empty($_GET["id"] && $_GET["id"] >= 1)){
            $this->model = $this->controller->show($this->model);
        }
	}
	
	/***********************************
	 * mantenedor prestaciones
	 ***********************************/
	//pagina listado de prestaciones
	public function prestacionesList(){
		$this->model = new \prestacionesList\ModelPrestaciones($this->pdo);
		$this->view = new \prestacionesList\ViewPrestaciones;
		$this->controller = new \prestacionesList\ControllerPrestaciones;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->filter($this->model);
		}
		if(!empty($_GET["id"])){
            $this->controller->delete($this->model);
		}
		
		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}
	}

	//pagina agregado de prestaciones
	public function prestacionesNew(){
		$this->model = new \prestacionesNew\ModelPrestaciones($this->pdo);
		$this->view = new \prestacionesNew\ViewPrestaciones;
		$this->controller = new \prestacionesNew\ControllerPrestaciones;
		$this->model = $this->controller->all($this->model);
		if(!empty($_GET["id"])){
			$this->model = $this->controller->edit($this->model);
		}
	}

	public function prestacionesShow(){


        $this->model = new \prestacionesShow\ModelPrestaciones($this->pdo);
        $this->view = new \prestacionesShow\ViewPrestaciones;
        $this->controller = new \prestacionesShow\ControllerPrestaciones;

        //si no esta vacío el dato id de la url
        if(!empty($_GET["id"] && $_GET["id"] >= 1)){
            $this->model = $this->controller->show($this->model);
        }
    }



	/***********************************
	 * mantenedor usuarios
	 ***********************************/
	//pagina listado de usuarios
	public function usuariosList(){
		$this->model = new \usuariosList\ModelUsuarios($this->pdo);
		$this->view = new \usuariosList\ViewUsuarios;
		$this->controller = new \usuariosList\ControllerUsuarios;
		$this->model = $this->controller->all($this->model);

        if(!empty($_GET["restore"])){
            $this->model->restore();
        }

		if(!empty($_GET["id"])){
            $this->controller->delete($this->model);
        }



		if(isset($_GET["page"])){
			$this->model = $this->controller->page($this->model);
		}

		
	}

	//pagina agregado de usuarios
	public function usuariosNew(){
		$this->model = new \UsuariosNew\ModelUsuarios($this->pdo);
		$this->view = new \UsuariosNew\ViewUsuarios;
		$this->controller = new \UsuariosNew\ControllerUsuarios;
		$this->model = $this->controller->all($this->model);


		if(!empty($_GET["id"])){
			$this->model = $this->controller->edit($this->model);
		}
	}



	/***********************************
	 * Genericos
	 ***********************************/
	//"renderiza" la vista solicitada anteriormente dentro de la plantilla
	public function display(){
		$this->templateModel = new \TemplateCYC\ModelTemplateCYC($this->pdo);
		
		$this->templateView = new \TemplateCYC\ViewTemplateCYC;
		
		$this->templateController = new \TemplateCYC\ControllerTemplateCYC;
	
		$this->templateController->all($this->templateModel);
		
		echo $this->templateView->output($this->templateModel, $this->view->output($this->model));
			
		oci_close($this->pdo);
	}


	//pagina por defecto para rutas no validas, 
	//modelo y controlador no realizan acciones, 
	//solo estan para mantener esquema
	public function notFound(){
		$this->model = new \notFound\ModelNotFound($this->pdo);
		$this->view = new \notFound\ViewNotFound;
		$this->controller = new \notFound\ControllerNotFound;
		$this->controller->all($this->model);
		http_response_code(404);
	}

	//solo estan para mantener esquema
	public function home(){
		
		$this->model = new \Home\ModelHome($this->pdo);
		$this->view = new \Home\ViewHome;
		$this->controller = new \Home\ControllerHome;
		
		$this->controller->all($this->model);
		
	}

	//solo estan para mantener esquema
	public function login(){
		$this->model = new \LoginCYC\ModelLoginCYC($this->pdo);
		$this->view = new \LoginCYC\ViewLoginCYC;
		$this->controller = new \LoginCYC\ControllerLoginCYC;
		$this->controller->all($this->model);
		echo $this->view->output($this->model);
		die();
	}
	//solo estan para mantener esquema
	public function logout(){
		$this->model = new \LogoutCYC\ModelLogoutCYC($this->pdo);
		$this->view = new \LogoutCYC\ViewLogoutCYC;
		$this->controller = new \LogoutCYC\ControllerLogoutCYC;
		$this->controller->all($this->model);
	}

    public function archivoDownload()
    {

        if (!isset($_GET['id'])){
            throw new Exception("Debe mandar la variable id por la url");
            exit();
        }

        $query = "SELECT * FROM documento WHERE NRO_DOCUMENTO = " . (int) $_GET['id'];
        $result = oci_parse($this->pdo, $query);
        oci_execute($result);

        $row = queryResultToAssoc($result)[0];


        //cuando no encuentra nigun registro en la base de datos que corresponda al id enviado por la url
        if (is_null($row)) {
            header('Status: 404 Not Found');
            exit();
        }
        //Cuando si encuentra el registro en la base de datos
        else {

            $archivo = $row['ARCHIVO']->load();

            header("Content-type:" .$row['TIPO_ARCHIVO']);
            header('Content-Disposition: attachment; filename='.$row["NOMBRE"]);

            print $archivo;
        }


 
	}

	public function detalle(){
		$this->view = new \ContratosList\Detalles;
	}
}