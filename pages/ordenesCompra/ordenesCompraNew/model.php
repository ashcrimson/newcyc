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


	private $id_contrato;
	private $presupuesto;
	private $archivo_licitacion;
	private $descripcion_licitacion;

	//Constructor
	function __construct($pdo){
		$this->pdo = $pdo;
	}

	//retorna el/los datos seleccionados
	public function new(){

		$result = [];
		$assoc = [];
		$listado = [];


		//validacion de datos recividos
		$params = "";
		if(isset($_POST["submit"])){
			if(isset($_POST["id_contrato"]) && $_POST["id_contrato"] != ""){
				$this->params .= "id_contrato" . $_POST["id_contrato"] . "&";
				$this->contratos = $_POST["id_contrato"];
			}else{
				$this->errores["id_contrato"] = true;
				$this->error = true;
			}

			if(isset($_POST["presupuesto"]) && $_POST["presupuesto"] != ""){
				$this->params .= "presupuesto=" . $_POST["presupuesto"] . "&";
				$this->presupuesto = $_POST["presupuesto"];
			}else{
				$this->errores["presupuesto"] = true;
				$this->error = true;
			}

			// if(isset($_POST["archivo_licitacion"]) && $_POST["archivo_licitacion"] != ""){
			// 	$params .= "archivo_licitacion=" . $_POST["archivo_licitacion"] . "&";
			// }else{
			// 	$errores["archivo_licitacion"] = true;
			// 	$error = true;
			// }

			if(isset($_POST["descripcion_licitacion"]) && $_POST["descripcion_licitacion"] != ""){
				$this->params .= "descripcion_licitacion=" . $_POST["descripcion_licitacion"] . "&";
				$this->descripcion_licitacion = $_POST["descripcion_licitacion"];
			}else{
				$this->errores["descripcion_licitacion"] = true;
				$this->error = true;
			}
		}

		return new self($this->pdo);

	}

	public function execute(){
		
		//validar si faltó algo
		if(!$this->error){
			//consulta de inserción
			//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
			// $consulta = "INSERT into ORDEN_COMPRA values (
			// 			'". $this->nro_licitacion ."',
			// 			0,
			// 			'". $this->descripcion_licitacion ."',
			// 			".  $this->presupuesto .",
			// 			TO_DATE('2020-09-09 14:30:00','yyyy-mm-dd hh24-mi-ss'), null, null)";

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
			//print_r("redirige");
			header("Location: ". base() . "/ordenCompra/new?" . $params);
			die();
		}

		

		//agrega resultados a retorno
		//array_push($assoc, $listado);
		//array_push($assoc, $errores);

		//$results["result"] = $result;

		oci_close($this->pdo);
		//return $assoc;
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