<?php



namespace LicitacionesNew;


/**
 * modelo de lista de  licitaciones
 */
class ModelLicitaciones {

	/**
	 * varaibles globales
	 */
	//Obj de conexion de db
	private $pdo;
	private $error = false;
	private $errores = [];
	private $params = "";


	private $nro_licitacion;
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
			if(isset($_POST["nro_licitacion"]) && $_POST["nro_licitacion"] != ""){
				$this->params .= "nro_licitacion=" . $_POST["nro_licitacion"] . "&";
				$this->nro_licitacion = $_POST["nro_licitacion"];
			}else{
				$this->errores["nro_licitacion"] = true;
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

			$numero = 0;
			// if(isset($_FILES["archivo_licitacion"]) && $_FILES["archivo_licitacion"] != ""){
				
			// 	$cons = "SELECT COUNT(*)+1 AS CTA FROM DOC_DETALLE";
			// 	$result = oci_parse($this->pdo, $cons);
			// 	oci_execute($result);
			// 	$numero = queryResultToAssoc($result)[0]["CTA"];
			// 	print_r($numero);

			// 	$directorio = "uploads/";
			// 	$archivo = $directorio . basename($_FILES["archivo_licitacion"]["name"]);
			// 	move_uploaded_file($_FILES["archivo_licitacion"]["tmp_name"], $archivo);

			// 	//consulta de inserción
			// 	//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
			// 	$consulta = "INSERT into DOC_DETALLE (NRO_DOCUMENTO, NOMBRE, FECHA_CREACION) values (
			// 				'". $numero ."',
			// 				'". $archivo ."',
			// 				TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'))";

			// 	//ejecucion consulta
			// 	$query = $consulta;
			// 	$result = oci_parse($this->pdo, $query);
			// 	//print_r($consulta);
			// 	oci_execute($result);
			// }


			//consulta de inserción
			//$consulta = "SELECT * FROM LICITACIONES " . " ORDER BY FECHA_CREACION DESC";
			$consulta = "INSERT into LICITACIONES values (
						'". $this->nro_licitacion ."',
						'". $this->descripcion_licitacion ."',
						".  $this->presupuesto .",
						TO_DATE('". date('yy-m-d') ."','yyyy-mm-dd'), null, null)";

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
			header("Location: ". base() . "/licitaciones/new?" . $params);
			die();
		}

		

		//agrega resultados a retorno
		//array_push($assoc, $listado);
		//array_push($assoc, $errores);

		//$results["result"] = $result;

		oci_close($this->pdo);
		//return $assoc;
	}
}