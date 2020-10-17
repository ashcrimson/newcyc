<?php



namespace OrdenCompraNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelOrdenCompra {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";

	private $nro_orden_compra;
	private $id_contrato;
	

	//Constructor
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recibidos
		$params = "";
		if(isset($_POST["submit"])){

			if(isset($_POST["nro_orden_compra"]) && $_POST["nro_orden_compra"] != ""){
				$this->params .= "nro_orden_compra" . $_POST["nro_orden_compra"] . "&";
				$this->nro_orden_compra = $_POST["nro_orden_compra"];
			}else{
				$this->errores["nro_orden_compra"] = true;
				$this->error = true;
			}

			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato" . $_POST["id_contrato"] . "&";
				$this->id_contrato = $_POST["id_contrato"];
			}else{
				$this->errores["id_contrato"] = true;
				$this->error = true;
			}
			
			
		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			

			$consulta = "INSERT INTO ORDEN_COMPRA VALUES (
				'111', 
				'". $this->id_contrato ."', 
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
				'111',
				'111',
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'),
				TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss')
				)";

			//ejecucion consulta
			$query = $consulta;
			$result = oci_parse($this->pdo, $query);
			//print_r($consulta);
			oci_execute($result);

			//oci_error();
			//$listado = queryResultToAssoc($result);
			oci_commit($this->pdo);
		}else{
			print_r("TODO MALO");
			// header("Location: ". base() . "/ordenCompra/new?" . $params);
			die();
		}


		oci_close($this->pdo);
		// return $assoc;
		
	}

	public function get(){
		
		$assoc = [];


		//consulta para recuperar los ids de los contratos
		$query = "SELECT ID_CONTRATO FROM CONTRATOS";
		$result = oci_parse($this->pdo, $query);
		oci_execute($result);
		$contratos = queryResultToAssoc($result);
		array_push($assoc, $contratos);




		oci_close($this->pdo);
		return $assoc;


	}
}